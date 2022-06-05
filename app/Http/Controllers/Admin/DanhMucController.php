<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DanhMuc;
use App\Http\Requests\StoreDanhMucRequest;
use App\Http\Requests\UpdateDanhMucRequest;
use Illuminate\Support\Facades\Redirect;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listDanhMuc = DanhMuc::with('childs')->get();

        return view('admin.danhmuc.index-danhmuc', ['lstDanhMuc' => $listDanhMuc]);
    }

    public function getDanhMucSanPham()
    {
        $lstdanhMuc =
            DanhMuc::orderBy('slug', 'desc')->get();

        $lstDanhMucNew = [];
        DanhMuc::dequyDanhMuc($lstdanhMuc, $idDanhMucCha = 0, $level = 1, $lstDanhMucNew);
        return $lstDanhMucNew;
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
            'slug' => 'required|unique:danh_mucs',
        ], [
            'tenDanhMuc.required' => "Tên danh mục không được bỏ trống",
            'tenDanhMuc.unique' => 'Tên danh mục không được trùng',
            'slug.required' => "Slug không được bỏ trống",
            'slug.unique' => 'Slug không được trùng',
        ]);

        $danhmuc = new DanhMuc();
        $idDanhMucCha = $request->input('idDanhMucCha') != 0 ? $request->input('idDanhMucCha') : null;

        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $request->input('slug'),
            'idDanhMucCha' => $idDanhMucCha,
        ]);

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
        //
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
        return view('admin.danhmuc.edit-danhmuc', ['danhmuc'=> $danhmuc,'danhMucCha' => $listDanhMucCha]);
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
            'slug' => 'required',
            
        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'slug.required' => "Slug không được bỏ trống"
        ]);
        $idDanhMucCha = $request->input('idDanhMucCha') != null ? $request->input('idDanhMucCha') : 0; 
        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $request->input('slug'),
            'idDanhMucCha' => $idDanhMucCha,
        ]);

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
