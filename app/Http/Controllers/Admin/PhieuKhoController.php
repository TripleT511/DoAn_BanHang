<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\PhieuKho;
use App\Http\Requests\StorePhieuKhoRequest;
use App\Http\Requests\UpdatePhieuKhoRequest;
use App\Models\ChiTietPhieuKho;
use App\Models\HinhAnh;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Double;

use function GuzzleHttp\Promise\all;

class PhieuKhoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->get();

        return View('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    public function themChiTietPhieuKho(Request $request)
    {
        $idSanPham = $request->sanpham;
        $sanpham = SanPham::whereId($idSanPham)->first();
        $sanpham['soluong'] = 1;
        $lstSP = Session::get('lstSanPham');
        if ($lstSP) {
            if (isset($lstSP[$idSanPham])) {
                $lstSP[$idSanPham]['soluong'] = (int)$lstSP[$idSanPham]['soluong'] +  1;
            } else {
                $lstSP[$idSanPham] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $sanpham->tenSanPham,
                    "sku" => $sanpham->sku,
                    "donViTinh" => "Cái",
                    "soluong" => 1,
                    "gia" => $sanpham->gia,
                    "tongTien" => $sanpham->gia,
                );
            }
            Session::put("lstSanPham", $lstSP);
        } else {
            $lstSP[$idSanPham] = array(
                "id" => $idSanPham,
                "tenSanPham" => $sanpham->tenSanPham,
                "sku" => $sanpham->sku,
                "donViTinh" => "Cái",
                "soluong" => 1,
                "gia" => $sanpham->gia,
                "tongTien" => $sanpham->gia,
            );
            Session::put("lstSanPham", $lstSP);
        }
        return
            Session::get('lstSanPham');
    }

    public function updateChiTietPhieuKho(Request $request)
    {
        $idSanPham = $request->id;
        $lstSP = Session::get('lstSanPham');

        $lstSP[$idSanPham]['soluong'] = $request->soluong;
        $lstSP[$idSanPham]['gia'] = $request->gia;
        $lstSP[$idSanPham]['tongTien'] = (int)$lstSP[$idSanPham]['soluong'] * (float)$lstSP[$idSanPham]['gia'];

        Session::put('lstSanPham', $lstSP);

        return
            Session::get('lstSanPham');
    }

    public function xoaChiTietPhieuKho(Request $request)
    {
        $idSanPham = $request->id;
        $lstSP = Session::get('lstSanPham');
        unset($lstSP[$idSanPham]);

        Session::put('lstSanPham', $lstSP);

        return
            Session::get('lstSanPham');
    }

    public function renderList()
    {
        $new = Session::get('lstSanPham');
        $output = "";
        if (isset($new)) {
            foreach ($new as $key => $item) {
                $output .= '
                <tr>
                    <td class="name">' . $item['tenSanPham'] . '</td>
                    <td>' . $item['sku'] . '</td>
                    <td>' . $item['donViTinh'] . '</td>
                    <td><input type="text" name="soLuongSP" value="' . $item['soluong'] . '" class="form-control input-sl"  placeholder="Nhập số lượng" /></td>
                    <td><input type="text" name="soLuongSP" value="' . $item['gia'] . '" class="form-control input-gia"  placeholder="Nhập giá" /></td>
                    <td>' . $item['tongTien'] . 'đ</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xoa" data-id="' . $item['id'] . '" 
                            >Xoá</button>
                        <button type="button" class="btn btn-primary btn-update" data-id="' . $item['id'] . '" 
                            >Cập nhật</button>
                    </td>
                </tr>
                ';
            }
        }

        return response()->json($output);
    }

    public function searchSanPham(Request $request)
    {
        $output = "";

        if ($request->input('txtSearch') != "") {
            $lstSanPham = SanPham::where('tenSanPham', 'LIKE', '%' . $request->input('txtSearch') . '%')->with('hinhanhs')->get();
            foreach ($lstSanPham as $key => $item) {
                $hinhAnh = '';
                foreach ($item->hinhanhs as $key => $item2) {
                    if ($key == 1) break;
                    $this->fixImage($item2);
                    $hinhAnh = $item2->hinhAnh;
                }

                $output .=
                    '<li class="product-search-item product-item' . $item->id . '" data-id="' . $item->id . '">
                        <div class="product-search-img">
                            <img src="' . asset('storage/' . $hinhAnh) . '" alt="' . $item->tenSanPham . '">
                        </div>
                        <div class="product-search-content">
                            <p class="product-name">
                            ' . $item->tenSanPham . '
                            </p>
                            <p class="product-price">
                            <span>' . $item->gia  . '</span> đ
                            </p>
                        </div>
                    </li>';
            }
        }
        return response()->json($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstNCC = NhaCungCap::all();
        return view('admin.kho.create-nhapkho', ['lstNCC' => $lstNCC]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhieuKhoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhieuKhoRequest $request)
    {
        $request->validate([
            'maDonHang' => 'required|unique:phieu_khos',
        ], [
            'maDonHang.required' => "Mã đơn hàng không được bỏ trống",
        ]);


        // === Thêm phiếu kho === //



        $phieukho = new PhieuKho();
        $phieukho->fill([
            'maDonHang' => $request->input('maDonHang'),
            'nha_cung_cap_id' => $request->input('nhacungcapid'),
            'user_id' => Auth::user()->id,
            'ngayTao' => Carbon::now(),
            'ghiChu' =>
            $request->input('ghiChu'),
            'loaiPhieu' => $request->input('loaiPhieu'),
            'trangThai' => 0
        ]);
        $phieukho->save();

        $lstChiTietPhieuKho = Session::get('lstSanPham');

        foreach ($lstChiTietPhieuKho as $key => $value) {
            $chitietpk = new ChiTietPhieuKho();
            $chitietpk->fill([
                'phieu_kho_id' => $phieukho->id,
                'san_pham_id' => $value['id'],
                'sku' => $value['sku'],
                'donVi' => $value['donViTinh'],
                'soLuong' => $value['soluong'],
                'gia' => $value['gia'],
                'tongTien' => $value['tongTien']
            ]);
            $chitietpk->save();
        }

        // Xoa Session
        Session::flush('lstSanPham');

        $lstPhieuKho = PhieuKho::all();



        return View('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhieuKho  $phieuKho
     * @return \Illuminate\Http\Response
     */
    public function show(PhieuKho $phieuKho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhieuKho  $phieuKho
     * @return \Illuminate\Http\Response
     */
    public function edit(PhieuKho $phieuKho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhieuKhoRequest  $request
     * @param  \App\Models\PhieuKho  $phieuKho
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhieuKhoRequest $request, PhieuKho $phieukho)
    {
        if ($request->trangThai == 0) {

            $phieukho->trangThai = 1;


            $phieukho->save();

            $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->get();

            return View('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuKho  $phieuKho
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuKho $phieukho)
    {
        //
    }

    public function xemPhieuKho(Request $request)
    {
        $output = "";
        $phieuKho =
            PhieuKho::whereId($request->id)->with('nhacungcap')->with('user')->first();
        $chitietpk = ChiTietPhieuKho::where('phieu_kho_id', $phieuKho->id)->with('sanpham')->get();

        $output .= ' <h3 class="text-center">Chi Tiết Phiếu Kho</h3>
                    <dl class="row mt-2">
                        <dt class="col-sm-3">Mã đơn hàng:</dt>
                        <dd class="col-sm-9" id="maDonHang">' . $phieuKho->maDonHang . '</dd>
                        <dt class="col-sm-3">Người nhập hàng:</dt>
                        <dd class="col-sm-9" id="nguoiNhap">
                          ' . $phieuKho->user->hoTen . '
                        </dd>
                        <dt class="col-sm-3">Nội dung nhập hàng</dt>
                        <dd class="col-sm-9">Etiam porta sem malesuada magna mollis euismod.</dd>
                        <dt class="col-sm-3 text-truncate">Ngày tạo</dt>
                        <dd class="col-sm-9" id="ngayTao">
                        ' . $phieuKho->ngayTao . '
                        </dd>
                        <div class="table-responsive text-nowrap">
                    </dl>';
        $output .= '<table class="table">
                        <thead>
                          <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Nhà Cung Cấp</th>
                            <th>Số Lượng</th>
                            <th>Đơn vị</th>
                            <th>Đơn giá</th>
                            <th>Tổng tiền</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">';
        foreach ($chitietpk as $value => $item) {
            $output .=
                '<tr>
                    <td>
                        ' .  $value + 1 . '
                    </td>
                    <td>
                        ' . $item->sanpham->tenSanPham .  '
                    </td>
                    <td>
                        ' . $phieuKho->nhacungcap->tenNhaCungCap . '
                    </td>
                    <td>
                        ' .  $item->soLuong . '
                    </td>
                    <td>
                        Cái
                    </td>
                    <td>         
                        ' .  $item->gia . '
                    </td>
                    <td>
                        ' . (float)$item->gia * (int)$item->soLuong . '
                    </td>
                </tr>';
        }
        $output .=   '</tbody>
                    </table>';
        return
            response()->json($output);
    }
}
