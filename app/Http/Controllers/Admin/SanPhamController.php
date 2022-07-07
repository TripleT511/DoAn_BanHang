<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\SanPham;
use App\Models\HinhAnh;
use App\Models\DanhMuc;

use App\Http\Requests\StoreSanPhamRequest;
use App\Http\Requests\UpdateSanPhamRequest;
use App\Models\ThuocTinh;
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
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->paginate(5);
        foreach ($lstSanPham as $key => $item) {
            foreach ($item->hinhanhs as $item2) {
                $this->fixImage($item2);
            }
        }

        return View('admin.sanpham.index-sanpham', ['lstSanPham' => $lstSanPham]);
    }

    public function searchSanPham(Request $request)
    {
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->paginate(5);
        if ($request->keyword != "") {
            $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')
            ->where('tenSanPham', 'LIKE', '%' . $request->input('keyword') . '%')
            ->orWhere('sku', 'LIKE', '%' . $request->input('keyword') . '%')->paginate(5);
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
        $lstThuocTinh = ThuocTinh::all();
        $lstTuyChonThuocTinh = TuyChonThuocTinh::all();
        Session::forget("lstThuocTinh");
        $lstDanhMucCha = DanhMuc::where('idDanhMucCha', null)->get();
        return View('admin.sanpham.create-sanpham', ['lstDanhMuc' => $lstDanhMucCha, 'lstThuocTinh' => $lstThuocTinh, 'lstTuyChonThuocTinh' => $lstTuyChonThuocTinh]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSanPhamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSanPhamRequest $request)
    {

        dd($request);
        $request->validate([
            'tenSanPham' => 'required|unique:san_phams',
            'maSKU' => 'required'
        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'tenSanPham.unique' => "Tên sản phẩm bị trùng",
            'maSKU.required' => "Mã sản phẩm không được bỏ trống"
        ]);


        // === Thêm sản phẩm === //
        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tenSanPham'))->slug('-');
        }


        $sanpham = new SanPham();
        $sanpham->fill([
            'sku' => $request->input('maSKU'),
            'tenSanPham' => $request->input('tenSanPham'),
            'moTa' => $request->input('moTa'),
            'noiDung' => $request->input('noiDung'),
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

        Session::flush("lstThuocTinh");

        $lstSanPham = SanPham::all();

        return View('admin.sanpham.index-sanpham')->with('lstSanPham', $lstSanPham);
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
        $lstDanhMucCha = DanhMuc::where('idDanhMucCha', null)->get();
        $lstHinhAnh = HinhAnh::where('san_pham_id', $sanpham->id)->get();
        foreach ($lstHinhAnh as $item) {
            $this->fixImage($item);
        }

        return View('admin.sanpham.edit-sanpham', ['sanpham' => $sanpham, 'lstDanhMuc' => $lstDanhMucCha, 'lstHinhAnh' => $lstHinhAnh]);
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
            'maSKU' => 'required'
        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'maSKU.required' => "Mã sản phẩm không được bỏ trống"
        ]);

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
                Storage::disk('public')->delete($item->hinhAnh);
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
            Storage::disk('public')->delete($item->hinhAnh);
            $item->delete();
        }

        $sanpham->delete();
    }
}
