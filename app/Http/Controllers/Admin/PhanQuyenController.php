<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PhanQuyen;
use App\Http\Requests\StorePhanQuyenRequest;
use App\Http\Requests\UpdatePhanQuyenRequest;

class PhanQuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listPhanQuyen = PhanQuyen::all();
        return view('admin.phanquyen.index-phanquyen', ['lstPhanQuyen' => $listPhanQuyen]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.phanquyen.create-phanquyen');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhanQuyenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhanQuyenRequest $request)
    {
        $request->validate([
            'tenViTri' => 'required|unique:phan_quyens|string',
            'viTri' => 'required|unique:phan_quyens',
            
        ], [
            'tenViTri.required' => "Tên vị trí không được bỏ trống",
            'tenViTri.unique' => "Tên vị trí bị trùng",
            'viTri.required' => "Mã vị trí không được bỏ trống",
            'viTri.unique' => "Mã vị trí bị trùng",

        ]);

        $phanquyen = new PhanQuyen();
        $phanquyen->fill([
            'tenViTri'=> $request->input('tenViTri'),
            'viTri'=> $request->input('viTri'),
        ]);
        $phanquyen->save();
        return Redirect::route('phanquyen.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function show(PhanQuyen $phanQuyen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function edit(PhanQuyen $phanQuyen)
    {
        return view('admin.phanquyen.edit-phanquyen', ['phanquyen' => $phanquyen]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhanQuyenRequest  $request
     * @param  \App\Models\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhanQuyenRequest $request, PhanQuyen $phanQuyen)
    {
        $request->validate([
            'tenViTri' => 'required',
            'viTri' => 'required',  
        ], [
            'tenViTri.required' => "Tên vị trí không được bỏ trống",
            'viTri.required' => "Mã vị trí không được bỏ trống",
        ]);
        $phanquyen->fill([
            'tenViTri'=> $request->input('tenViTri'),
            'viTri'=> $request->input('viTri'),
        ]);
        $phanquyen->save();
        return Redirect::route('phanquyen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhanQuyen $phanQuyen)
    {
        $phanquyen->delete();
        return Redirect::route('phanquyen.index',);
    }
}
