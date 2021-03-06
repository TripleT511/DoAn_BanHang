<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PhieuKhoExport;
use App\Http\Controllers\Controller;


use App\Models\PhieuKho;
use App\Http\Requests\StorePhieuKhoRequest;
use App\Http\Requests\UpdatePhieuKhoRequest;
use App\Models\BienTheSanPham;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use App\Models\DanhMuc;
use App\Models\HinhAnh;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use App\Models\ThuocTinhSanPham;
use App\Models\TuyChonBienThe;
use App\Models\TuyChonThuocTinh;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;


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
        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->orderBy('created_at', 'desc')->paginate(7);

        return View('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    public function searchPhieuKho(Request $request)
    {
        $stringSearch = $request->keyword;
        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->whereHas('nhacungcap', function ($query) use ($stringSearch) {
            $query->where(
                'tenNhaCungCap',
                'LIKE',
                '%' . $stringSearch . '%'
            );
        })->orWhereHas('user', function ($query) use ($stringSearch) {
            $query->where(
                'hoTen',
                'LIKE',
                '%' . $stringSearch . '%'
            );
        })->orWhere('id', $stringSearch)->orWhere(
            'maDonHang',
            'LIKE',
            '%' . $stringSearch . '%'
        )->orderBy('created_at', 'desc')->paginate(7);


        return view('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    public function phieuChoDuyet(Request $request)
    {
        if ($request->has('trangThai') && $request->trangThai == 0) {
            $lstPhieuKho =
                PhieuKho::with('nhacungcap')->with('user')->where('trangThai', 0)->orderBy('created_at', 'desc')->paginate(7);
            return view('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
        } else {
            return Redirect::route('phieukho.index');
        }
    }


    public function locPhieuKho(Request $request)
    {
        $lstPhieuKho = "";

        $request->validate(
            [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate'
            ],
            [
                'startDate.required' => "Ng??y b???t ?????u kh??ng ???????c b??? tr???ng",
                'startDate.date' => "Ng??y b???t ?????u kh??ng h???p l???",
                'endDate.date' => "Ng??y b???t ?????u kh??ng h???p l???",
                'endDate.required' => "Ng??y k???t th??c kh??ng ???????c b??? tr???ng",
                'endDate.after_or_equal' => "Ng??y k???t th??c kh??ng ???????c nh??? h??n ng??y b???t ?????u",
            ]
        );

        $lstPhieuKho = PhieuKho::with('nhacungcap')->with('user')->where('trangThai', 0)->whereBetween('created_at', [$request->startDate, $request->endDate])->orderBy('created_at', 'desc')->paginate(7);
        return view('admin.kho.index-kho')->with('lstPhieuKho', $lstPhieuKho);
    }

    public function themSanPham(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'tenSanPham' => 'required|unique:san_phams',
                'sku' => 'required|unique:san_phams,sku',
                'danhmucid' => 'required',
                'mausac' => 'required',
                'mausac.required' => "M??u s???c s???n ph???m c???n ???????c ch???n"
            ],
            [
                'tenSanPham.required' => "T??n s???n ph???m kh??ng ???????c b??? tr???ng",
                'tenSanPham.unique' => "T??n s???n ph???m b??? tr??ng",
                'sku.unique' => "M?? s???n ph???m b??? tr??ng",
                'sku.required' => "M?? s???n ph???m kh??ng ???????c b??? tr???ng",
                'danhmucid.required' => "Danh m???c b???t bu???c ch???n",
                'mausac.required' => "M??u s???c s???n ph???m c???n ???????c ch???n"
            ]
        );

        if ($request->has('giaTriThuocTinh') && $request->filled('giaTriThuocTinh')) {

            $validator2 = Validator::make(
                $request->all(),
                [
                    'giaTriThuocTinh' => 'required',
                    'giaTriThuocTinh.*' => 'required',
                    'variant_sku.*' => 'required|unique:bien_the_san_phams,sku',
                    'variant_price.*' => 'required|integer',
                    'variant_price_sale.*' => "integer",
                ],
                [
                    'giaTriThuocTinh.required' => "Size b???t bu???c ch???n",
                    'giaTriThuocTinh.*.required' => "Gi?? tr??? c???a Size kh??ng ???????c b??? tr???ng",
                    'variant_sku.*.required' => "M?? s???n ph???m bi???n th??? kh??ng ???????c b??? tr???ng",
                    'variant_sku.*.unique' => "M?? s???n ph???m bi???n th??? kh??ng ???????c tr??ng",
                    'variant_price.*.required' => "Gi?? s???n ph???m bi???n th??? kh??ng ???????c b??? tr???ng",
                    'variant_price.*.integer' => "Gi?? s???n ph???m bi???n th??? ph???i l?? s???",
                    'variant_price_sale.*.integer' => "Gi?? khuy???n m??i s???n ph???m bi???n th??? ph???i l?? s???",
                ]
            );

            if ($validator2->fails()) {
                $error = '';
                foreach ($validator2->errors()->all() as $item) {
                    $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
                }
                return response()->json(['error' => $error]);
            }

            foreach ($request->variant_price as $key => $value) {
                if ($value != 0) {
                    $validator3 = Validator::make(
                        $request->all(),
                        [
                            "variant_price_sale.$key" => "max:$value",
                        ],
                        [
                            "variant_price_sale.$key.max" => "Gi?? khuy???n m??i kh??ng ???????c l???n h??n gi?? g???c",
                        ]
                    );

                    if ($validator3->fails()) {
                        $error = '';
                        foreach ($validator3->errors()->all() as $item) {
                            $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
                        }
                        return response()->json(['error' => $error]);
                    }
                }
            }
        }

        if ($request->filled('gia')) {
            $validator2 = Validator::make(
                $request->all(),
                [
                    'gia' => 'integer',
                ],
                [
                    'gia.integer' => "Gi?? ph???i l?? s???",
                ]
            );
            if ($validator2->fails()) {
                $error = '';
                foreach ($validator2->errors()->all() as $item) {
                    $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
                }
                return response()->json(['error' => $error]);
            }
        }

        if ($request->filled('giaKhuyenMai')) {
            $gia = $request->filled('gia') ? $request->gia : 0;
            $validator2 = Validator::make(
                $request->all(),
                [
                    'giaKhuyenMai' => "integer|max:$gia",
                ],
                [
                    "giaKhuyenMai.integer" => "Gi?? khuy???n m??i ph???i l?? s???",
                    'giaKhuyenMai.max' => "Gi?? khuy???n m??i kh??ng ???????c l???n h??n gi?? g???c",
                ]
            );

            if ($validator2->fails()) {
                $error = '';
                foreach ($validator2->errors()->all() as $item) {
                    $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
                }
                return response()->json(['error' => $error]);
            }
        }



        if ($validator->fails()) {
            $error = '';
            foreach ($validator->errors()->all() as $item) {
                $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
            }
            return response()->json(['error' => $error]);
        }


        // === Th??m s???n ph???m === //
        $slug = '';
        if ($request->slug) {
            $slug = $request->slug;
        } else {
            $slug = Str::of($request->tenSanPham)->slug('-');
        }

        $sku = '';

        if (!$request->sku) {
            $sku = "SP" .  Str::uuid(5);
        } else {
            $sku = $request->sku;
        }

        $moTa = str_replace("../../", "../../../", $request->moTa);
        $noiDung = str_replace("../../", "../../../", $request->noiDung);

        $sanpham = new SanPham();
        $sanpham->fill([
            'sku' => $sku,
            'tenSanPham' => $request->tenSanPham,
            'moTa' => $moTa,
            'noiDung' => $noiDung,
            'dacTrung' => $request->dacTrung,
            'gia' => $request->gia,
            'giaKhuyenMai' => $request->giaKhuyenMai,
            'danh_muc_id' => $request->danhmucid,
            'slug' => $slug,
        ]);
        $sanpham->save();

        // Th??m h??nh ???nh
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
        } else {
            $hinhAnh = new HinhAnh();

            $hinhAnh->fill([
                'san_pham_id' => $sanpham->id,
                'hinhAnh' => 'images/no-image-available.jpg',
            ]);

            $hinhAnh->save();
        }

        // Th??m bi???n th??? s???n ph???m

        $thuoctinhSanPham = new ThuocTinhSanPham();
        $thuoctinhSanPham->fill([
            'san_pham_id' => $sanpham->id,
            'thuoc_tinh_id' => 2,
        ]);
        $thuoctinhSanPham->save();

        $bienTheSanPham = new BienTheSanPham();
        $bienTheSanPham->fill([
            'san_pham_id' => $sanpham->id,
            'sku' => $sanpham->sku,
            'gia' => $sanpham->gia,
            'giaKhuyenMai' => $sanpham->giaKhuyenMai,
            'soLuong' => 0,
        ]);
        $bienTheSanPham->save();

        $tuyChonBienThe = new TuyChonBienThe();
        $tuyChonBienThe->fill([
            'bien_the_san_pham_id' => $bienTheSanPham->id,
            'tuy_chon_thuoc_tinh_id' => $request->mausac
        ]);
        $tuyChonBienThe->save();

        // 
        $idSanPham = $sanpham->id;
        $sanpham = SanPham::whereId($idSanPham)->with('color')->first();
        $sanpham['soluong'] = 1;
        $lstSP = Session::get('lstSanPham');
        $stringTenSanPham = $sanpham->tenSanPham . " - " . $sanpham->color->tuychonbienthe->color->tieuDe;
        //

        // Size
        if ($request->has('giaTriThuocTinh') && $request->filled('giaTriThuocTinh')) {
            $thuoctinhSanPhamSize = new ThuocTinhSanPham();
            $thuoctinhSanPhamSize->fill([
                'san_pham_id' => $sanpham->id,
                'thuoc_tinh_id' => 1,
            ]);
            $thuoctinhSanPhamSize->save();

            foreach ($request->giaTriThuocTinh as $key => $value) {
                $bienTheSanPhamSize = new BienTheSanPham();
                $bienTheSanPhamSize->fill([
                    'san_pham_id' => $sanpham->id,
                    'sku' => $request->variant_sku[$key],
                    'gia' => $request->variant_price[$key],
                    'giaKhuyenMai' => $request->variant_price_sale[$key],
                    'soLuong' => 0,
                ]);
                $bienTheSanPhamSize->save();

                $tuyChonBienTheSize = new TuyChonBienThe();
                $tuyChonBienTheSize->fill([
                    'bien_the_san_pham_id' => $bienTheSanPhamSize->id,
                    'tuy_chon_thuoc_tinh_id' => $value
                ]);
                $tuyChonBienTheSize->save();

                $tuyChonThuocTinhName = TuyChonThuocTinh::where('id', $value)->first();

                $lstSP[$bienTheSanPhamSize->sku] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $stringTenSanPham . " - " . $tuyChonThuocTinhName->tieuDe,
                    "sku" => $bienTheSanPhamSize->sku,
                    "soluong" => 1,
                    "giaBan" => $bienTheSanPhamSize->gia,
                    "tongTien" => $bienTheSanPhamSize->gia,
                );

                Session::put("lstSanPham", $lstSP);
            }
        } else {
            if ($lstSP) {
                if (isset($lstSP[$sanpham->sku])) {
                    $lstSP[$sanpham->sku]['soluong'] = (int)$lstSP[$sanpham->sku]['soluong'] +  1;
                    $lstSP[$sanpham->sku]['tongTien'] = (int)$lstSP[$sanpham->sku]['soluong'] * (float)$lstSP[$sanpham->sku]['gia'];
                } else {
                    $lstSP[$sanpham->sku] = array(
                        "id" => $idSanPham,
                        "tenSanPham" => $stringTenSanPham,
                        "sku" => $sanpham->sku,
                        "soluong" => 1,
                        "giaBan" => $sanpham->gia,
                        "tongTien" => $sanpham->gia,
                    );
                }
                Session::put("lstSanPham", $lstSP);
            } else {
                $lstSP[$sanpham->sku] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $stringTenSanPham,
                    "sku" => $sanpham->sku,
                    "soluong" => 1,
                    "giaBan" => $sanpham->gia,
                    "tongTien" => $sanpham->gia,
                );
                Session::put("lstSanPham", $lstSP);
            }
        }



        return response()->json(['success' => "Th??m s???n ph???m th??nh c??ng", "error" => null]);
    }

    public function themChiTietPhieuKho(Request $request)
    {

        $idSanPham = $request->sanpham;
        $sanpham = SanPham::whereId($idSanPham)->with('color')->with('sizes')->withCount('soluongthuoctinh')->first();
        $sanpham['soluong'] = 1;
        $lstSP = Session::get('lstSanPham');

        $stringTenSanPham = $sanpham->tenSanPham . " - " . $sanpham->color->tuychonbienthe->color->tieuDe;

        if ($lstSP) {
            if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {
                unset($sanpham->sizes[0]);
                foreach ($sanpham->sizes as $size) {
                    if (isset($lstSP[$size->sku])) {
                        $lstSP[$size->sku]['soluong'] = (int)$lstSP[$size->sku]['soluong'] +  1;
                        $lstSP[$size->sku]['tongTien'] = (int)$lstSP[$size->sku]['soluong'] * (float)$lstSP[$size->sku]['giaBan'];
                    } else {
                        $lstSP[$size->sku] = array(
                            "id" => $sanpham->id,
                            "tenSanPham" => $stringTenSanPham . " - " . $size->tuychonbienthe->sizes->tieuDe,
                            "sku" => $size->sku,
                            "soluong" => 1,
                            "giaBan" => $size->gia,
                            "tongTien" => $size->gia,
                        );
                    }
                }
            } else {
                if (isset($lstSP[$sanpham->sku])) {
                    $lstSP[$sanpham->sku]['soluong'] = (int)$lstSP[$sanpham->sku]['soluong'] +  1;
                    $lstSP[$sanpham->sku]['tongTien'] = (int)$lstSP[$sanpham->sku]['soluong'] * (float)$lstSP[$sanpham->sku]['giaBan'];
                } else {
                    $lstSP[$sanpham->sku] = array(
                        "id" => $sanpham->id,
                        "tenSanPham" => $sanpham->tenSanPham,
                        "sku" => $sanpham->sku,
                        "soluong" => 1,
                        "giaBan" => $sanpham->gia,
                        "tongTien" => $sanpham->gia,
                    );
                }
            }

            Session::put("lstSanPham", $lstSP);
        } else {

            if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {
                unset($sanpham->sizes[0]);
                foreach ($sanpham->sizes as $size) {
                    $lstSP[$size->sku] = array(
                        "id" => $sanpham->id,
                        "tenSanPham" => $stringTenSanPham . " - " . $size->tuychonbienthe->sizes->tieuDe,
                        "sku" => $size->sku,
                        "soluong" => 1,
                        "giaBan" => $size->gia,
                        "tongTien" => $size->gia,
                    );
                }
            } else {

                $lstSP[$sanpham->sku] = array(
                    "id" => $sanpham->id,
                    "tenSanPham" => $stringTenSanPham,
                    "sku" => $sanpham->sku,
                    "soluong" => 1,
                    "giaBan" => $sanpham->gia,
                    "tongTien" => $sanpham->gia,
                );
            }

            Session::put("lstSanPham", $lstSP);
        }
        return
            Session::get('lstSanPham');
    }

    public function updateChiTietPhieuKho(Request $request)
    {

        $sku = $request->id;
        $lstSP = Session::get('lstSanPham');


        $lstSP[$sku]['soluong'] = $request->soluong;
        $lstSP[$sku]['tongTien'] = (int)$lstSP[$sku]['soluong'] * (float)$lstSP[$sku]['giaBan'];

        Session::put('lstSanPham', $lstSP);

        return
            Session::get('lstSanPham');
    }

    public function xoaChiTietPhieuKho(Request $request)
    {
        $sku = $request->id;
        $lstSP = Session::get('lstSanPham');
        unset($lstSP[$sku]);

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
                    <td><input type="text" name="soLuongSP" value="' . $item['soluong'] . '" class="form-control input-sl"  placeholder="Nh???p s??? l?????ng" /></td>
                    <td>' . $item['giaBan'] . '</td>
                    <td>' . $item['tongTien'] . '</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xoa" data-id="' . $item['sku'] . '" 
                            >Xo??</button>
                        <button type="button" class="btn btn-primary btn-update" data-id="' . $item['sku'] . '" 
                            >C???p nh???t</button>
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
                                   Gi??: <span>' . $item->gia  . '</span>
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
        $lstDanhMucCha = DanhMuc::all();
        $lstNCC = NhaCungCap::all();

        $lstMauSac = TuyChonThuocTinh::where('thuoc_tinh_id', 2)->get();
        $lstSize = TuyChonThuocTinh::where('thuoc_tinh_id', 1)->get();

        return view('admin.kho.create-nhapkho', ['lstNCC' => $lstNCC, 'lstDanhMuc' => $lstDanhMucCha, 'lstMauSac' => $lstMauSac, 'lstSize' => $lstSize]);
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
            'nhacungcapid' => 'required',
        ], [
            'maDonHang.unique' => "M?? ????n h??ng kh??ng ???????c tr??ng",
            'nhacungcapid.required' => "Nh?? cung c???p b???t bu???c ch???n"
        ]);

        $ngayTao =  Carbon::now();

        if ($request->has('ngayTao') && $request->filled('ngayTao')) {
            $request->validate([
                'ngayTao' => 'date|before_or_equal:today',
            ], [
                'ngayTao.before_or_equal' => "Ng??y t???o phi???u kh??ng ???????c l???n h??n ng??y hi???n t???i",
                'ngayTao.date' => "Ng??y t???o phi???u kh??ng h???p l???",
            ]);

            $ngayTao = $request->ngayTao;
        }

        if ($request->has('maDonHang') && $request->filled('maDonHang')) {
            $request->validate([
                'maDonHang' => 'unique:phieu_khos,maDonHang',
            ], [
                'maDonHang.unique' => "M?? ????n h??ng ???? t???n t???i",
            ]);
        }

        // === Th??m phi???u kho === //
        $maDonHang = '';

        if (!$request->input('maDonHang')) {
            $maDonHang = Str::uuid(10);
        } else {
            $maDonHang = $request->input('maDonHang');
        }

        $phieukho = new PhieuKho();
        $phieukho->fill([
            'maDonHang' => $maDonHang,
            'nha_cung_cap_id' => $request->input('nhacungcapid'),
            'user_id' => Auth::user()->id,
            'ngayTao' => $ngayTao,
            'ghiChu' => $request->input('ghiChu'),
            'trangThai' => 0
        ]);
        $phieukho->save();

        $lstChiTietPhieuKho = Session::get('lstSanPham');
        if ($lstChiTietPhieuKho) {
            foreach ($lstChiTietPhieuKho as $key => $value) {
                $chitietpk = new ChiTietPhieuKho();
                $chitietpk->fill([
                    'phieu_kho_id' => $phieukho->id,
                    'san_pham_id' => $value['id'],
                    'sku' => $value['sku'],
                    'soLuong' => $value['soluong'],
                    'gia' => $value['giaBan'],
                    'tongTien' => $value['tongTien']
                ]);
                $chitietpk->save();
            }
        }


        // Xoa Session
        Session::forget('lstSanPham');

        return Redirect::route('phieukho.index');
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

            $chitietpk = ChiTietPhieuKho::where('phieu_kho_id', $phieukho->id)->get();
            foreach ($chitietpk as $item) {
                $sanpham = SanPham::whereId($item->san_pham_id)->with('color')->withCount('soluongthuoctinh')->first();
                if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {
                    $bienTheSanPham = BienTheSanPham::where('sku', $item->sku)->first();
                    $bienTheSanPham->soLuong = (int)$bienTheSanPham->soLuong + $item->soLuong;
                    $bienTheSanPham->save();
                } else {
                    $sanpham->tonKho = $sanpham->tonKho + $item->soLuong;
                    $bienTheSanPham = BienTheSanPham::where('san_pham_id', $sanpham->id)->first();
                    $bienTheSanPham->soLuong = $bienTheSanPham->soLuong + $item->soLuong;
                    $bienTheSanPham->save();
                    $sanpham->save();
                }
            }
        }

        return Redirect::route('phieukho.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhieuKho  $phieuKho
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhieuKho $phieukho)
    {
        $chitietpk = ChiTietPhieuKho::where('phieu_kho_id', $phieukho->id)->get();
        foreach ($chitietpk as $item) {
            $item->delete();
        }

        $phieukho->delete();
        return Redirect::back();
    }

    public function xemPhieuKho(Request $request)
    {
        $output = "";
        $tongSL = 0;
        $tongSP = 0;
        $tongTien = 0;
        $phieuKho =
            PhieuKho::whereId($request->id)->with('nhacungcap')->with('user')->first();
        $chitietpk = ChiTietPhieuKho::where('phieu_kho_id', $phieuKho->id)->with('sanpham')->with('sanpham.color')->with('sanpham.soluongthuoctinh')->get();
        $trangThai = $phieuKho->trangThai == 0 ? "??ang ch??? duy???t" : "???? thanh to??n";
        $output .= ' <h3 class="text-center">PHI???U NH???P KHO</h3>
                    <dl class="row mt-2">
                        <dt class="col-sm-3">M?? ????n h??ng:</dt>
                        <dd class="col-sm-3" id="maDonHang">' . $phieuKho->maDonHang . '</dd>
                        <dt class="col-sm-3">Nh?? cung c???p:</dt>
                        <dd class="col-sm-3" id="nhaCungCap">
                          ' . ($phieuKho->nha_cung_cap_id ? $phieuKho->nhacungcap->tenNhaCungCap : '') . '
                        </dd>
                        <dt class="col-sm-3 text-truncate">Th???i gian:</dt>
                        <dd class="col-sm-3" id="ngayTao">
                        ' . $phieuKho->created_at->format('d') . '-' .  $phieuKho->created_at->format('m') . '-' .  $phieuKho->created_at->format('Y')  . '
                        </dd>
                        <dt class="col-sm-3">Ng?????i t???o:</dt>
                        <dd class="col-sm-3" id="nguoiNhap">
                          ' . ($phieuKho->user ? $phieuKho->user->hoTen : '') . '
                        </dd>
                        <dt class="col-sm-3">Tr???ng th??i:</dt>
                        <dd class="col-sm-3" id="trangThai">
                          ' . $trangThai . '
                        </dd>
                        <dt class="col-sm-3">Ghi ch??</dt>
                        <dd class="col-sm-3">' . $phieuKho->ghiChu . '</dd>
                        
                    </dl>';
        $output .= '<table class="table">
                        <thead>
                          <tr>
                            <th>STT</th>
                            <th>M?? h??ng</th>
                            <th>T??n s???n ph???m</th>
                            <th>S??? L?????ng</th>
                            <th>????n gi??</th>
                            <th>Th??nh ti???n</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">';
        foreach ($chitietpk as $value => $item) {
            $tongSL += $item->soLuong;
            $tongSP += 1;
            $tongTien += (int)$item->soLuong * (float)$item->gia;
            $tieuDeColor = $item->sanpham->color->tuychonbienthe->color->tieuDe;
            $tieuDeSize = "";
            $countThuonTinh = count($item->sanpham->soluongthuoctinh);
            if ($countThuonTinh > 1) {

                $bienTheSanPham = BienTheSanPham::where([
                    'sku' => $item->sku,
                    'san_pham_id' => $item->san_pham_id,
                ])->withTrashed()->first();

                $bienTheSize = TuyChonBienThe::withTrashed()->where('bien_the_san_pham_id', $bienTheSanPham->id)->with('thuoctinh')->first();
                if ($bienTheSize)
                    $tieuDeSize = $bienTheSize->thuoctinh->tieuDe;
            }

            $output .=
                '<tr>
                    <td>
                        ' .  $value + 1 . '
                    </td>
                    <td>
                        ' . $item->sku . '
                    </td>
                    <td>
                        ' . $item->sanpham->tenSanPham . '-' . $tieuDeColor . '-' . $tieuDeSize . '
                    </td>
                    
                    <td>
                        ' .  $item->soLuong . '
                    </td>
                    <td>         
                        ' .   number_format($item->gia, 0, ',', ',') . ' ???
                    </td>
                    <td>
                        ' .  number_format((float)$item->gia * (int)$item->soLuong, 0, ',', ',') . ' ???
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
                                <dt class="col-sm-5 text-right">T???ng s??? l?????ng: </dt>
                                <dd class="col-sm-7 text-right">' . $tongSL . '</dd>
                                <dt class="col-sm-5 text-right">T???ng s??? m???t h??ng: </dt>
                                <dd class="col-sm-7 text-right">' . $tongSP . '</dd>
                                <dt class="col-sm-5 text-right">T???ng ti???n h??ng: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($tongTien, 0, ',', ',') . ' ???</dd>
                                <dt class="col-sm-5 text-right">T???ng c???ng: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($tongTien, 0, ',', ',') .  ' ???</dd>
                            </div>
                        </div>
                    </div>
                    ';
        Session::put('pdfPhieuKho', $phieuKho);
        return
            response()->json([
                'data' => $output,
            ]);
    }

    public function PhieuKhoPDF()
    {
        $data = Session::get('pdfPhieuKho');

        $chitietphieukho =
            ChiTietPhieuKho::where('phieu_kho_id', $data["id"])->with('sanpham')->get();
        foreach ($chitietphieukho as $item) {
            $tieuDeColor = $item->sanpham->color->tuychonbienthe->color->tieuDe;
            $tieuDeSize = "";
            $countThuonTinh = count($item->sanpham->soluongthuoctinh);
            if ($countThuonTinh > 1) {

                $bienTheSanPham = BienTheSanPham::where([
                    'sku' => $item->sku,
                    'san_pham_id' => $item->san_pham_id,
                ])->withTrashed()->first();

                $bienTheSize = TuyChonBienThe::withTrashed()->where('bien_the_san_pham_id', $bienTheSanPham->id)->with('thuoctinh')->first();
                if ($bienTheSize)
                    $tieuDeSize = $bienTheSize->thuoctinh->tieuDe;
            }

            $item->tieuDeColor = $tieuDeColor;
            $item->tieuDeSize = $tieuDeSize;
        }
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML($data);
        $data = [
            'phieukho'     => $data,
            'chitietphieukho' => $chitietphieukho
        ];
        $pdf = PDF::loadView('admin.pdf.kho', $data);

        return $pdf->stream();
    }
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    public function ExportPhieuKho()
    {
        return $this->excel->download(new PhieuKhoExport, 'phieukho.xlsx');
    }
}
