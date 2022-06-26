<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\MaGiamGia;
use App\Http\Requests\StoreMaGiamGiaRequest;
use App\Http\Requests\UpdateMaGiamGiaRequest;
use Illuminate\Support\Str;

class MaGiamGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDiscount = MaGiamGia::all();
        return view('admin.discount.index-discount', ['lstDiscount' => $lstDiscount]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create-discount');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMaGiamGiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaGiamGiaRequest $request)
    {
        $request->validate([
            'tenMa' => 'required',
            'moTa' => 'required',
            'soLuong' => 'required|integer',
            'loaiKhuyenMai' => 'required',
            'giaTriKhuyenMai' => 'required',
            'ngayBatDau'    => 'required',
            'ngayKetThuc' => 'required',
        ], [
            'tenMa.required' => "Tên danh mục không được bỏ trống",
            'moTa.required' => "Mô tả không được bỏ trống",
            'soLuong.required' => "Số lượng không được bỏ trống",
            'soLuong.interger' => "Số lượng không hợp lệ",
            'loaiKhuyenMai.required' => "Loại khuyến mãi không được bỏ trống",
            'giaTriKhuyenMai.required' => "Giá trị khuyến mãi không được bỏ trống",
            'ngayBatDau.required' => "Ngày bắt đầu bắt buộc chọn",
            'ngayKetThuc.required' => "Ngày kết thúc bắt buộc chọn",
        ]);

        $code = '';
        if ($request->filled('code')) {
            $code = $request->input('code');
        } else {
            $code = Str::random(10);
        }

        $discount = new MaGiamGia();
        $discount->fill([
            'code' => strtoupper($code),
            'tenMa' => $request->tenMa,
            'hinhAnh' => '',
            'moTa' => $request->moTa,
            'soLuong' => $request->filled('soLuong') ? $request->soLuong : 1,
            'loaiKhuyenMai' => $request->loaiKhuyenMai,
            'giaTriKhuyenMai' => $request->giaTriKhuyenMai,
            'mucGiamToiDa' => $request->mucGiamToiDa,
            'ngayBatDau' => $request->ngayBatDau,
            'ngayKetThuc' => $request->ngayKetThuc,
            'giaTriToiThieu' => $request->giaTriToiThieu,
        ]);

        if ($request->hasFile('hinhAnh')) {
            $discount->hinhAnh = $request->file('hinhAnh')->store('images/discount', 'public');
        }
        $discount->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function show(MaGiamGia $maGiamGia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function edit(MaGiamGia $maGiamGia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaGiamGiaRequest  $request
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaGiamGiaRequest $request, MaGiamGia $maGiamGia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaGiamGia $maGiamGia)
    {
        //
    }
}
