<?php

namespace App\Http\Controllers;

use App\Models\LuotTimKiem;
use App\Http\Requests\StoreLuotTimKiemRequest;
use App\Http\Requests\UpdateLuotTimKiemRequest;

class LuotTimKiemController extends Controller
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
     * @param  \App\Http\Requests\StoreLuotTimKiemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLuotTimKiemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LuotTimKiem  $luotTimKiem
     * @return \Illuminate\Http\Response
     */
    public function show(LuotTimKiem $luotTimKiem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LuotTimKiem  $luotTimKiem
     * @return \Illuminate\Http\Response
     */
    public function edit(LuotTimKiem $luotTimKiem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLuotTimKiemRequest  $request
     * @param  \App\Models\LuotTimKiem  $luotTimKiem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLuotTimKiemRequest $request, LuotTimKiem $luotTimKiem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LuotTimKiem  $luotTimKiem
     * @return \Illuminate\Http\Response
     */
    public function destroy(LuotTimKiem $luotTimKiem)
    {
        //
    }
}
