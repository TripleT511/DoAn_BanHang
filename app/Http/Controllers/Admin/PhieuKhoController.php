<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\PhieuKho;
use App\Http\Requests\StorePhieuKhoRequest;
use App\Http\Requests\UpdatePhieuKhoRequest;
use App\Models\ChiTietPhieuKho;
use App\Models\DanhMuc;
use App\Models\HinhAnh;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


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
        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->paginate(7);

        return View('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    public function themSanPham(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tenSanPham' => 'required|unique:san_phams',
                'sku' => 'unique:san_phams,sku',
                'noiDung' => 'required',
                'danhmucid' => 'required',
                'moTa' => 'required',
                'hinhAnh' => 'required'
            ],
            [
                'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
                'tenSanPham.unique' => "Tên sản phẩm bị trùng",
                'sku.unique' => "Mã sản phẩm không được trùng",
                'noiDung.required' => "Nội dung không được bỏ trống",
                'moTa.required' => "Mô tả không được bỏ trống",
                'danhmucid.required' => "Danh mục bắt buộc chọn",
                'hinhAnh.required' => "Hình ảnh bắt buộc chọn",
            ]
        );

        if ($validator->fails()) {
            $error = '';
            foreach ($validator->errors()->all() as $item) {
                $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
            }
            return response()->json(['error' => $error]);
        }


        // === Thêm sản phẩm === //
        $slug = '';
        if ($request->slug) {
            $slug = $request->slug;
        } else {
            $slug = Str::of($request->tenSanPham)->slug('-');
        }

        $sku = '';

        if (!$request->sku) {
            $sku = "SP" .  Str::random(15);
        } else {
            $sku = $request->sku;
        }

        $sanpham = new SanPham();
        $sanpham->fill([
            'sku' => $sku,
            'tenSanPham' => $request->tenSanPham,
            'moTa' => $request->moTa,
            'noiDung' => $request->noiDung,
            'dacTrung' => $request->dacTrung,
            'gia' => $request->gia,
            'giaKhuyenMai' => $request->giaKhuyenMai,
            'danh_muc_id' => $request->danhmucid,
            'slug' => $slug
        ]);
        $sanpham->save();

        // Thêm hình ảnh
        if ($request->hasFile('hinhAnh')) {

            foreach ($request->file('hinhAnh') as $item) {
                $hinhAnh = new HinhAnh();

                $hinhAnh->fill([
                    'san_pham_id' => $sanpham->id,
                    'hinhAnh' => '',
                ]);

                $hinhAnh->save();
                $hinhAnh->hinhAnh = $item->store('images/san-pham', 'public');
                $hinhAnh->save();
            }
        }

        $idSanPham = $sanpham->id;
        $sanpham = SanPham::whereId($idSanPham)->first();
        $sanpham['soluong'] = 1;
        $lstSP = Session::get('lstSanPham');
        if ($lstSP) {
            if (isset($lstSP[$idSanPham])) {
                $lstSP[$idSanPham]['soluong'] = (int)$lstSP[$idSanPham]['soluong'] +  1;
                $lstSP[$idSanPham]['tongTien'] = (int)$lstSP[$idSanPham]['soluong'] * (float)$lstSP[$idSanPham]['gia'];
            } else {
                $lstSP[$idSanPham] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $sanpham->tenSanPham,
                    "sku" => $sanpham->sku,
                    "donViTinh" => "Cái",
                    "soluong" => 1,
                    "gia" => 0,
                    "giaBan" => $sanpham->gia,
                    "tongTien" => 0,
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
                "gia" => 0,
                "giaBan" => $sanpham->gia,
                "tongTien" => 0,
            );
            Session::put("lstSanPham", $lstSP);
        }
        return response()->json(['success' => "Thêm sản phẩm thành công"]);
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
                $lstSP[$idSanPham]['tongTien'] = (int)$lstSP[$idSanPham]['soluong'] * (float)$lstSP[$idSanPham]['gia'];
            } else {
                $lstSP[$idSanPham] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $sanpham->tenSanPham,
                    "sku" => $sanpham->sku,
                    "donViTinh" => "Cái",
                    "soluong" => 1,
                    "gia" => 0,
                    "giaBan" => $sanpham->gia,
                    "tongTien" => 0,
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
                "gia" => 0,
                "giaBan" => $sanpham->gia,
                "tongTien" => 0,
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
        if ((float)$request->gia > (float)$lstSP[$idSanPham]['giaBan']) {
            return response()->json(['error' => "Giá nhập không thể lớn hơn giá bán"]);
        }

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
                    <td>' . $item['sku'] . '</td>
                    <td class="name">' . $item['tenSanPham'] . '</td>
                    <td>' . $item['donViTinh'] . '</td>
                    <td><input type="text" name="soLuongSP" value="' . $item['soluong'] . '" class="form-control input-sl"  placeholder="Nhập số lượng" /></td>
                    <td><input type="text" name="soLuongSP" value="' . $item['gia'] . '" class="form-control input-gia"  placeholder="Nhập giá" />
                    <input type="hidden" name="giaBan" value="' . $item['giaBan'] . '" class="form-control" />
                    </td>
                    <td>' . $item['tongTien'] . '</td>
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
                            <div class="product-description">
                                <p class="product-sku">
                                    <span>' . $item->sku  . '</span>
                                </p>
                                <p class="product-price">
                                   Giá: <span>' . $item->gia  . '</span>
                                </p>
                            </div>
                        </div>
                    </li>';
            }
        }
        return response()->json($output);
    }

    public function chonSanPham(Request $request)
    {

        $lstSanPham = SanPham::whereId($request->sanpham)->with('hinhanhs')->first();
        foreach ($lstSanPham->hinhanhs as $key => $item2) {
            $this->fixImage($item2);
        }

        return response()->json($lstSanPham);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDanhMucCha = DanhMuc::where('idDanhMucCha', null)->get();
        $lstNCC = NhaCungCap::all();
        return view('admin.kho.create-nhapkho', ['lstNCC' => $lstNCC, 'lstDanhMuc' => $lstDanhMucCha]);
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
            'maDonHang' => 'unique:phieu_khos',
        ], [
            'maDonHang.unique' => "Mã đơn hàng không được trùng",
        ]);


        // === Thêm phiếu kho === //
        $maDonHang = '';

        if (!$request->input('maDonHang')) {
            $maDonHang = $request->input('loaiPhieu') == 0 ? "PN" . Str::random(10) : "PX" . Str::random(10);
        } else {
            $maDonHang = $request->input('maDonHang');
        }


        $phieukho = new PhieuKho();
        $phieukho->fill([
            'maDonHang' => $maDonHang,
            'nha_cung_cap_id' => $request->input('nhacungcapid'),
            'user_id' => Auth::user()->id,
            'ngayTao' => Carbon::now(),
            'ghiChu' => $request->input('ghiChu'),
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

            // Update giá nhập sản phẩm
            $sanpham = SanPham::whereId($value['id'])->first();
            $sanpham->giaNhap = $value['gia'];
            $sanpham->save();
        }

        // Xoa Session
        Session::flush('lstSanPham');
        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->get();

        return  Redirect::route('phieukho.index', ['lstPhieuKho' => $lstPhieuKho]);
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
        $tongSL = 0;
        $tongSP = 0;
        $tongTien = 0;
        $phieuKho =
            PhieuKho::whereId($request->id)->with('nhacungcap')->with('user')->first();
        $chitietpk = ChiTietPhieuKho::where('phieu_kho_id', $phieuKho->id)->with('sanpham')->get();
        $trangThai = $phieuKho->trangThai == 0 ? "Đang chờ duyệt" : "Đã thanh toán";
        $output .= ' <h3 class="text-center">Chi Tiết Phiếu Kho</h3>
                    <dl class="row mt-2">
                        <dt class="col-sm-3">Mã đơn hàng:</dt>
                        <dd class="col-sm-3" id="maDonHang">' . $phieuKho->maDonHang . '</dd>
                        <dt class="col-sm-3">Nhà cung cấp:</dt>
                        <dd class="col-sm-3" id="nhaCungCap">
                          ' . $phieuKho->nhacungcap->tenNhaCungCap . '
                        </dd>
                        <dt class="col-sm-3 text-truncate">Thời gian</dt>
                        <dd class="col-sm-3" id="ngayTao">
                        ' . $phieuKho->ngayTao . '
                        </dd>
                        <dt class="col-sm-3">Người tạo:</dt>
                        <dd class="col-sm-3" id="nguoiNhap">
                          ' . $phieuKho->user->hoTen . '
                        </dd>
                        <dt class="col-sm-3">Trạng thái:</dt>
                        <dd class="col-sm-3" id="trangThai">
                          ' . $trangThai . '
                        </dd>
                        <dt class="col-sm-3">Ghi chú</dt>
                        <dd class="col-sm-3">' . $phieuKho->ghiChu . '</dd>
                        
                    </dl>';
        $output .= '<table class="table">
                        <thead>
                          <tr>
                            <th>STT</th>
                            <th>Mã hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Số Lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">';
        foreach ($chitietpk as $value => $item) {
            $tongSL += $item->soLuong;
            $tongSP += 1;
            $tongTien += (int)$item->soLuong * (float)$item->gia;
            $output .=
                '<tr>
                    <td>
                        ' .  $value + 1 . '
                    </td>
                    <td>
                        ' . $item->sku . '
                    </td>
                    <td>
                        ' . $item->sanpham->tenSanPham .  '
                    </td>
                    
                    <td>
                        ' .  $item->soLuong . '
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
                    </table>
                    <div class="row">
                        <div class="col-md-8">
                            
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <dt class="col-sm-5 text-right">Tổng số lượng: </dt>
                                <dd class="col-sm-7 text-right">' . $tongSL . '</dd>
                                <dt class="col-sm-5 text-right">Tổng số mặt hàng: </dt>
                                <dd class="col-sm-7 text-right">' . $tongSP . '</dd>
                                <dt class="col-sm-5 text-right">Tổng tiền hàng: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($tongTien, 0, ',', ',') . '</dd>
                                <dt class="col-sm-5 text-right">Tổng cộng: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($tongTien, 0, ',', ',') . '</dd>
                            </div>
                        </div>
                    </div>
                    ';
        return
            response()->json($output);
    }
}
