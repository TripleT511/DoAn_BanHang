<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstHoaDon = HoaDon::paginate(5)->withQueryString();
        return view('admin.hoadon.index-hoadon', ['lstHoaDon' => $lstHoaDon]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function show(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function edit(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HoaDon $hoadon)
    {

        $hoadon->nhan_vien_id = Auth::user()->id;
        $hoadon->khach_hang_id = $hoadon->khach_hang_id;
        $hoadon->hoTen = $hoadon->hoTen;
        $hoadon->diaChi = $hoadon->diaChi;
        $hoadon->email = $hoadon->email;
        $hoadon->soDienThoai = $hoadon->soDienThoai;
        $hoadon->ngayXuatHD = $hoadon->ngayXuatHD;
        $hoadon->tongTien = $hoadon->tongTien;
        $hoadon->ghiChu = $hoadon->ghiChu;

        switch ($request->trangThai) {
            case '1':
                $hoadon->trangThai = 1;
                break;
            case '2':
                $hoadon->trangThai = 2;
                break;
            case '3':
                $hoadon->trangThai = 3;
                break;
            case '4':
                $hoadon->trangThai = 4;
                break;
            case '5':
                $hoadon->trangThai = 5;
                break;
            default:
                $hoadon->trangThai = 1;
                break;
        }

        $hoadon->save();

        return Redirect::route('hoadon.index', ['page' => $request->page_on]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function destroy(HoaDon $hoaDon)
    {
        //
    }
}
