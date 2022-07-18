<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\SanPham;
use App\Models\HinhAnh;
use App\Models\DanhMuc;

use App\Http\Requests\StoreSanPhamRequest;
use App\Http\Requests\UpdateSanPhamRequest;
use App\Models\BienTheSanPham;
use App\Models\ThuocTinh;
use App\Models\ThuocTinhSanPham;
use App\Models\TuyChonBienThe;
use App\Models\TuyChonThuocTinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class SanPhamController extends Controller
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
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('color')->with('sizes')->withCount('soluongthuoctinh')->orderBy('created_at', 'desc')->paginate(5);
        foreach ($lstSanPham as $key => $item) {
            foreach ($item->hinhanhs as $item2) {
                $this->fixImage($item2);
            }
        }

        return View('admin.sanpham.index-sanpham', ['lstSanPham' => $lstSanPham]);
    }

    public function searchSanPham(Request $request)
    {
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('color')->with('sizes')->withCount('soluongthuoctinh')->paginate(5);
        $stringSearch = $request->keyword;
        if ($request->keyword != "") {
            $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('color')->with('sizes')->withCount('soluongthuoctinh')->whereHas('danhmuc', function ($query) use ($stringSearch) {
                $query->where('tenDanhMuc', 'LIKE', '%' . $stringSearch . '%');
            })->orWhere('tenSanPham', 'LIKE', '%' . $stringSearch . '%')->orWhere('sku', 'LIKE', '%' . $stringSearch . '%')->paginate(5);
            foreach ($lstSanPham as $key => $item) {
                foreach ($item->hinhanhs as $item2) {
                    $this->fixImage($item2);
                }
            }
        }
        return View('admin.sanpham.index-sanpham', ['lstSanPham' => $lstSanPham]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstDanhMucCha = DanhMuc::all();

        $lstMauSac = TuyChonThuocTinh::where('thuoc_tinh_id', 2)->get();
        $lstSize = TuyChonThuocTinh::where('thuoc_tinh_id', 1)->get();

        return View('admin.sanpham.create-sanpham', ['lstDanhMuc' => $lstDanhMucCha, 'lstMauSac' => $lstMauSac, 'lstSize' => $lstSize]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSanPhamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSanPhamRequest $request)
    {

        $request->validate([
            'tenSanPham' => 'required|unique:san_phams,tenSanPham',
            'maSKU' => 'required|unique:san_phams,sku',
            'danhmucid' => 'required',
            'mausac' => 'required'
        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'tenSanPham.unique' => "Tên sản phẩm bị trùng",
            'maSKU.required' => "Mã sản phẩm không được bỏ trống",
            'maSKU.unique' => "Mã sản phẩm đã tồn tại",
            'danhmucid.required' => "Bắt buộc chọn danh mục",
            'mausac.required' => "Màu sắc sản phẩm cần được chọn"
        ]);

        if ($request->has('giaTriThuocTinh') && $request->filled('giaTriThuocTinh')) {
            $request->validate([
                'giaTriThuocTinh' => 'required',
                'giaTriThuocTinh.*' => 'required',
                'variant_sku.*' => 'required|unique:bien_the_san_phams,sku',
                'variant_price.*' => 'required|integer',
                'variant_price_sale.*' => "integer",
            ], [
                'giaTriThuocTinh.required' => "Size bắt buộc chọn",
                'giaTriThuocTinh.*.required' => "Giá trị của Size không được bỏ trống",
                'variant_sku.*.required' => "Mã sản phẩm biến thể không được bỏ trống",
                'variant_sku.*.unique' => "Mã sản phẩm biến thể không được trùng",
                'variant_price.*.required' => "Giá sản phẩm biến thể không được bỏ trống",
                'variant_price.*.integer' => "Giá sản phẩm biến thể phải là số",
                'variant_price_sale.*.integer' => "Giá khuyến mãi sản phẩm biến thể phải là số",
            ]);

            foreach ($request->variant_price as $key => $value) {
                if ($value != 0) {
                    $request->validate(
                        [
                            "variant_price_sale.$key" => "max:$value",
                        ],
                        [
                            "variant_price_sale.$key.max" => "Giá khuyến mãi không được lớn hơn giá gốc",
                        ]
                    );
                }
            }
        }


        if ($request->filled('giaKhuyenMai')) {
            $gia = $request->filled('gia') ? $request->gia : 0;
            $request->validate([
                'giaKhuyenMai' => "integer|max:$gia",
            ], [
                "giaKhuyenMai.integer" => "Giá khuyến mãi phải là số",
                'giaKhuyenMai.max' => "Giá khuyến mãi không được lớn hơn giá gốc",
            ]);
        }

        if ($request->filled('gia')) {
            $request->validate([
                'gia' => 'integer',
            ], [
                'gia.integer' => "Giá phải là số",
            ]);
        }

        // === Thêm sản phẩm === //
        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tenSanPham'))->slug('-');
        }

        $moTa =
            str_replace("../../", "../../../", $request->moTa);
        $noiDung = str_replace("../../", "../../../", $request->noiDung);

        $sanpham = new SanPham();
        $sanpham->fill([
            'sku' => $request->input('maSKU'),
            'tenSanPham' => $request->input('tenSanPham'),
            'moTa' => $moTa,
            'noiDung' => $noiDung,
            'dacTrung' => $request->input('dacTrung'),
            'gia' => $request->input('gia'), 'giaKhuyenMai' => $request->input('giaKhuyenMai'),
            'danh_muc_id' => $request->input('danhmucid'),
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

        // Thêm biến thể sản phẩm

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
            }
        }

        return Redirect::route('sanpham.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SanPham  $sanPham
     * @return \Illuminate\Http\Response
     */
    public function show(SanPham $sanPham)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SanPham  $sanPham
     * @return \Illuminate\Http\Response
     */
    public function edit(SanPham $sanpham)
    {
        $lstDanhMucCha = DanhMuc::all();
        $lstHinhAnh = HinhAnh::where('san_pham_id', $sanpham->id)->get();
        foreach ($lstHinhAnh as $item) {
            $this->fixImage($item);
        }

        $lstMauSac = TuyChonThuocTinh::where('thuoc_tinh_id', 2)->get();
        $lstSize = TuyChonThuocTinh::where('thuoc_tinh_id', 1)->get();


        $mauSacSanPham =
            BienTheSanPham::where('san_pham_id', $sanpham->id)->with('tuychonbienthe.color')->first();
        $lstBienTheSanPham = BienTheSanPham::where('san_pham_id', $sanpham->id)->with('tuychonbienthe.sizes')->get();
        $idMauSac = $mauSacSanPham->tuychonbienthe->color->id;

        return View('admin.sanpham.edit-sanpham', ['sanpham' => $sanpham, 'lstDanhMuc' => $lstDanhMucCha, 'lstHinhAnh' => $lstHinhAnh, 'lstMauSac' => $lstMauSac, 'lstSize' => $lstSize, 'lstBienTheSanPham' => $lstBienTheSanPham, 'idMauSac' => $idMauSac]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSanPhamRequest  $request
     * @param  \App\Models\SanPham  $sanPham
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSanPhamRequest $request, SanPham $sanpham)
    {

        $request->validate([
            'tenSanPham' => 'required',
            'maSKU' => 'required',
            'danhmucid' => 'required',
            'mausac' => 'required'
        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'maSKU.required' => "Mã sản phẩm không được bỏ trống",
            'danhmucid.required' => "Danh mục sản phẩm không được bỏ trống",
            'mausac.required' => "Màu sắc sản phẩm không được bỏ trống",
        ]);

        if ($request->has('giaTriThuocTinh') && $request->filled('giaTriThuocTinh')) {
            $request->validate([
                'giaTriThuocTinh' => 'required',
                'giaTriThuocTinh.*' => 'required',
                'variant_sku.*' => 'required',
                'variant_price.*' => 'required|integer',
                'variant_price_sale.*' => "integer",
            ], [
                'giaTriThuocTinh.required' => "Size bắt buộc chọn",
                'giaTriThuocTinh.*.required' => "Giá trị của Size không được bỏ trống",
                'variant_sku.*.required' => "Mã sản phẩm biến thể không được bỏ trống",
                'variant_price.*.required' => "Giá sản phẩm biến thể không được bỏ trống",
                'variant_price.*.integer' => "Giá sản phẩm biến thể phải là số",
                'variant_price_sale.*.integer' => "Giá khuyến mãi sản phẩm biến thể phải là số",
            ]);

            foreach ($request->variant_price as $key => $value) {
                if ($value != 0) {
                    $request->validate(
                        [
                            "variant_price_sale.$key" => "max:$value",
                        ],
                        [
                            "variant_price_sale.$key.max" => "Giá khuyến mãi không được lớn hơn giá gốc",
                        ]
                    );
                }
            }
        }

        if ($request->filled('tenSanPham') && $request->tenSanPham != $sanpham->tenSanPham) {
            $request->validate([
                'tenSanPham' => 'unique:san_phams,tenSanPham',
            ], [
                'tenSanPham.unique' => "Tên sản phẩm đã tồn tại",
            ]);
        }

        if ($request->filled('maSKU') && $request->maSKU != $sanpham->sku) {
            $request->validate([
                'maSKU' => 'unique:san_phams,sku',
            ], [
                'maSKU.unique' => "Mã sản phẩm đã tồn tại",
            ]);
        }

        if ($request->filled('giaKhuyenMai')) {
            $gia = $request->filled('gia') ? $request->gia : 0;
            $request->validate([
                'giaKhuyenMai' => "integer|max:$gia",
            ], [
                "giaKhuyenMai.integer" => "Giá khuyến mãi phải là số",
                'giaKhuyenMai.max' => "Giá khuyến mãi không được lớn hơn giá gốc",
            ]);
        }

        if ($request->filled('gia')) {
            $request->validate([
                'gia' => 'integer',
            ], [
                'gia.integer' => "Giá phải là số",
            ]);
        }

        $sanpham->fill([
            'sku' => $request->input('maSKU'),
            'tenSanPham' => $request->input('tenSanPham'),
            'moTa' => $request->input('moTa'),
            'noiDung' => $request->input('noiDung'),
            'dacTrung' => $request->input('dacTrung'),
            'gia' => $request->input('gia'), 'giaKhuyenMai' => $request->input('giaKhuyenMai'),
            'danh_muc_id' => $request->input('danhmucid'),
            'slug' => $request->input('slug')
        ]);

        $sanpham->save();

        if ($request->hasFile('hinhAnh')) {
            $hinhAnh = HinhAnh::where('san_pham_id', $sanpham->id)->get();

            foreach ($hinhAnh as $item) {
                if ($item->hinhAnh != 'images/no-image-available.jpg') {
                    Storage::disk('public')->delete($item->hinhAnh);
                }
                $item->delete();
            }

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

        // Cập nhật biến thể sản phẩm
        $bienTheMauSac = BienTheSanPham::where('san_pham_id', $sanpham->id)->with('tuychonbienthe.color')->first();
        $bienTheMauSac->sku = $sanpham->sku;
        $bienTheMauSac->gia = $sanpham->gia;
        $bienTheMauSac->giaKhuyenMai = $sanpham->giaKhuyenMai;
        $bienTheMauSac->save();

        $tuyChonBienTheMauSac = TuyChonBienThe::where('bien_the_san_pham_id', $bienTheMauSac->id)->first();
        $tuyChonBienTheMauSac->tuy_chon_thuoc_tinh_id = $request->mausac;
        $tuyChonBienTheMauSac->save();

        // Size

        if ($request->has('giaTriThuocTinh') && $request->filled('giaTriThuocTinh')) {
            $lstSizeNoneDelete = [];
            foreach ($request->giaTriThuocTinh as $key => $value) {

                $BienTheSizeExist = BienTheSanPham::where('san_pham_id', $sanpham->id)->whereHas('tuychonbienthe', function ($query) use ($value) {
                    $query->where('tuy_chon_thuoc_tinh_id', $value);
                })->first();

                if ($BienTheSizeExist) {
                    $BienTheSizeExist->sku = $request->variant_sku[$key];
                    $BienTheSizeExist->gia = $request->variant_price[$key];
                    $BienTheSizeExist->giaKhuyenMai = $request->variant_price_sale[$key];
                    $BienTheSizeExist->save();
                } else {
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
                }

                array_push($lstSizeNoneDelete, (int)$value);
            }

            $bienTheDelete =
                BienTheSanPham::where('san_pham_id', $sanpham->id)->whereHas('tuychonbienthe', function ($query) use ($lstSizeNoneDelete, $sanpham) {
                    $query->whereNot('sku', $sanpham->sku)->whereNotIn('tuy_chon_thuoc_tinh_id', $lstSizeNoneDelete);
                })->get();
            if ($bienTheDelete) {
                foreach ($bienTheDelete as $size) {
                    $tuychonBienTheDelete = TuyChonBienThe::where('bien_the_san_pham_id', $size->id)->delete();
                    $size->delete();
                }
            }
        }

        return Redirect::route('sanpham.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SanPham  $sanPham
     * @return \Illuminate\Http\Response
     */
    public function destroy(SanPham $sanpham)
    {
        $hinhAnh = HinhAnh::where('san_pham_id', $sanpham->id)->get();

        foreach ($hinhAnh as $item) {
            if ($item->hinhAnh != 'images/no-image-available.jpg') {
                Storage::disk('public')->delete($item->hinhAnh);
            }
            $item->delete();
        }

        $sanpham->delete();

        return Redirect::back();
    }
}
