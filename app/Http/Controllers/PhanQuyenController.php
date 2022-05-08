<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhanQuyenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhanQuyenRequest $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhanQuyen  $phanQuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhanQuyen $phanQuyen)
    {
        //
    }
}
