<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DanhMuc;
use App\Http\Requests\StoreDanhMucRequest;
use App\Http\Requests\UpdateDanhMucRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(DanhMuc $user)
    {
        if (Storage::disk('public')->exists($user->anhDaiDien)) {
            $user->anhDaiDien = $user->anhDaiDien;
        } else {
            $user->anhDaiDien = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $listDanhMuc = DanhMuc::with('childs')->paginate(10);
        $listDanhMucCha = DanhMuc::orderBy('slug', 'desc')->get();

        return view('admin.danhmuc.index-danhmuc', ['lstDanhMuc' => $listDanhMuc, 'danhMucCha' => $listDanhMucCha]);
    }


    public function searchDanhMuc(Request $request)
    {
        $lstDanhMuc =
            DanhMuc::with('childs')->paginate(5);
        if ($request->keyword != "") {
            $lstDanhMuc = DanhMuc::where('tenDanhMuc', 'LIKE', '%' . $request->keyword . '%')->with('childs')->paginate(5);
        }
        $listDanhMucCha = DanhMuc::orderBy('slug', 'desc')->get();
        return view('admin.danhmuc.index-danhmuc', ['lstDanhMuc' => $lstDanhMuc, 'danhMucCha' => $listDanhMucCha]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listDanhMucCha = DanhMuc::orderBy('slug', 'desc')->get();
        return view('admin.danhmuc.create-danhmuc', ['danhMucCha' => $listDanhMucCha]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDanhMucRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDanhMucRequest $request)
    {
        $request->validate([
            'tenDanhMuc' => 'required|unique:danh_mucs',
        ], [
            'tenDanhMuc.required' => "Tên danh mục không được bỏ trống",
            'tenDanhMuc.unique' => 'Tên danh mục không được trùng',
        ]);

        $danhmuc = new DanhMuc();
        $idDanhMucCha = $request->input('idDanhMucCha') != 0 ? $request->input('idDanhMucCha') : null;

        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tenDanhMuc'))->slug('-');
        }

        // Xác định cấp danh mục
        $level = 1;
        if ($idDanhMucCha != null) {
            $level = DanhMuc::find($idDanhMucCha)->level + 1;
        }

        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $slug,
            'idDanhMucCha' => $idDanhMucCha,
            'hinhAnh' => 'images/no-image-available.jpg',
            'level' => $level,
        ]);

        $danhmuc->save();

        if ($request->hasFile('hinhAnh')) {
            $danhmuc->hinhAnh = $request->file('hinhAnh')->store('images/danh-muc', 'public');
        }
        $danhmuc->save();


        return Redirect::route('danhmuc.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function show(DanhMuc $danhMuc)
    {
        return $danhMuc;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function edit(DanhMuc $danhmuc)
    {
        $listDanhMucCha = DanhMuc::orderBy('id', 'desc')->get();
        foreach ($listDanhMucCha as $key => $item) {
            if ($item->id == $danhmuc->id) {
                // Loại bỏ danh mục trùng với danh mục đang sửa
                $listDanhMucCha->forget($key);
            }
        }

        return view('admin.danhmuc.edit-danhmuc', ['danhmuc' => $danhmuc, 'danhMucCha' => $listDanhMucCha]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDanhMucRequest  $request
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDanhMucRequest $request, DanhMuc $danhmuc)
    {
        $request->validate([
            'tenDanhMuc' => 'required',

        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
        ]);

        if ($request->tenDanhMuc != $danhmuc->tenDanhMuc) {
            $request->validate([
                'tenDanhMuc' => 'unique:danh_mucs',
            ], [
                'tenDanhMuc.unique' => 'Tên danh mục không được trùng',
            ]);
        }
        $idDanhMucCha = $request->input('idDanhMucCha') != null && $request->input('idDanhMucCha') != $danhmuc->id ? $request->input('idDanhMucCha') : null;

        // Xác định cấp danh mục
        $level = $danhmuc->level;
        if ($idDanhMucCha != null) {
            $level = DanhMuc::find($idDanhMucCha)->level + 1;
        }

        $slug = $danhmuc->slug;
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        }

        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $slug,
            'idDanhMucCha' => $idDanhMucCha,
            'hinhAnh' => $danhmuc->hinhAnh,
            'level' => $level,
        ]);

        $danhmuc->save();

        if ($request->hasFile('hinhAnh')) {
            $danhmuc->hinhAnh = $request->file('hinhAnh')->store('images/danh-muc', 'public');
        }
        $danhmuc->save();

        return Redirect::route('danhmuc.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function destroy(DanhMuc $danhmuc)
    {
        $danhmuc->delete();
        return Redirect::route('danhmuc.index');
    }
}
