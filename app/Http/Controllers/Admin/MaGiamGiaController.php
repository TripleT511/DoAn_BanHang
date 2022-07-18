<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\MaGiamGia;
use App\Http\Requests\StoreMaGiamGiaRequest;
use App\Http\Requests\UpdateMaGiamGiaRequest;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;

class MaGiamGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(MaGiamGia $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
    public function index()
    {
        $lstDiscount = MaGiamGia::orderBy('created_at', 'desc')->paginate(4)->withQueryString();
        foreach ($lstDiscount as $item)
            $this->fixImage($item);
        return view('admin.discount.index-discount', ['lstDiscount' => $lstDiscount]);
    }

    public function indexDie()
    {
        $lstDiscount = MaGiamGia::where('ngayKetThuc', '<', date('Y-m-d', strtotime(date('Y-m-d') . " +1 days")))->orderBy('created_at', 'desc')->paginate(4)->withQueryString();
        foreach ($lstDiscount as $item)
            $this->fixImage($item);
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
            'code' => 'required',
            'tenMa' => 'required',
            'moTa' => 'required',
            'loaiKhuyenMai' => 'required',
            'giaTriKhuyenMai' => 'required|',
            'ngayBatDau'    => 'required|date|after_or_equal:today',
            'ngayKetThuc' => 'required|date|after_or_equal:ngayBatDau',
        ], [
            'code.required' => 'Mã giảm giá không được bỏ trống',
            'tenMa.required' => "Tên mã giảm giá không được bỏ trống",
            'moTa.required' => "Mô tả không được bỏ trống",
            'loaiKhuyenMai.required' => "Loại khuyến mãi không được bỏ trống",
            'giaTriKhuyenMai.required' => "Giá trị khuyến mãi không được bỏ trống",
            'ngayBatDau.required' => "Ngày bắt đầu bắt buộc chọn",
            'ngayBatDau.after_or_equal' => "Ngày bắt đầu không thể nhỏ hơn ngày hiện tại",
            'ngayKetThuc.required' => "Ngày kết thúc bắt buộc chọn",
            'ngayKetThuc.after_or_equal' => "Ngày kết thúc không thể nhỏ hơn ngày bắt đầu",
        ]);

        if ($request->loaiKhuyenMai == 1) {
            $request->validate([
                'giaTriKhuyenMai' => 'integer|between:1,100',
            ], [
                'giaTriKhuyenMai.between' => "Giá trị khuyến mãi tối thiểu là 1 và tối đa 100",
            ]);
        }

        if ($request->filled('mucGiamToiDa')) {
            $request->validate([
                'mucGiamToiDa' => 'integer|min:1001',
            ], [
                'mucGiamToiDa.interger' => "Mức giảm tối đa phải là số",
                'mucGiamToiDa.min' => "Mức giảm tối đa không thể nhỏ hơn 1000",
            ]);
        }

        if ($request->filled('giaTriToiThieu')) {
            $request->validate([
                'giaTriToiThieu' => 'integer|min:1',
            ], [
                'giaTriToiThieu.interger' => "Giá trị tối thiểu phải là số",
                'giaTriToiThieu.min' => "Giá trị tối thiểu không thể nhỏ hơn 1",
            ]);
        }

        if ($request->filled('soLuong')) {
            $request->validate([
                'soLuong' => 'integer|min:1',
            ], [
                'soLuong.interger' => "Số lượng phải là số",
                'soLuong.min' => "Số lượng không thể nhỏ hơn 1",
            ]);
        }



        $code = '';
        if ($request->filled('code')) {
            $code = $request->input('code');
        } else {
            $code = Str::random(10);
        }




        // Save Image FroalaEditor
        $moTa = str_replace("../../", "../../../", $request->moTa);
        $discount = new MaGiamGia();
        $discount->fill([
            'code' => strtoupper($code),
            'tenMa' => $request->tenMa,
            'hinhAnh' => 'images/no-image-available.jpg',
            'moTa' => $moTa,
            'soLuong' => $request->filled('soLuong') ? $request->soLuong : null,
            'loaiKhuyenMai' => $request->loaiKhuyenMai,
            'giaTriKhuyenMai' => $request->giaTriKhuyenMai,
            'mucGiamToiDa' => $request->mucGiamToiDa,
            'ngayBatDau' => $request->ngayBatDau,
            'ngayKetThuc' => $request->ngayKetThuc,
            'giaTriToiThieu' => $request->giaTriToiThieu,
        ]);
        $discount->hinhAnh = 'images/no-image-available.jpg';
        $discount->save();

        if ($request->hasFile('hinhAnh')) {
            $discount->hinhAnh = $request->file('hinhAnh')->store('images/discount', 'public');
        }
        $discount->save();

        return Redirect::route('discount.index');
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
    public function edit(MaGiamGia $discount)
    {

        return view('admin.discount.edit-discount', ['maGiamGia' => $discount]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMaGiamGiaRequest  $request
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaGiamGiaRequest $request, MaGiamGia $discount)
    {
        $request->validate([
            'tenMa' => 'required',
            'moTa' => 'required',
            'ngayKetThuc' => "required|date|after_or_equal:$discount->ngayBatDau",
        ], [
            'tenMa.required' => "Tên mã giảm giá không được bỏ trống",
            'moTa.required' => "Mô tả không được bỏ trống",
            'ngayKetThuc.required' => "Ngày kết thúc bắt buộc chọn",
            'ngayKetThuc.after_or_equal' => "Ngày kết thúc không thể nhỏ hơn ngày bắt đầu",
        ]);


        if ($request->filled('mucGiamToiDa')) {
            $request->validate([
                'mucGiamToiDa' => 'integer|min:1001',
            ], [
                'mucGiamToiDa.interger' => "Mức giảm tối đa phải là số",
                'mucGiamToiDa.min' => "Mức giảm tối đa không thể nhỏ hơn 1000",
            ]);
        }

        if ($request->filled('giaTriToiThieu')) {
            $request->validate([
                'giaTriToiThieu' => 'integer|min:1',
            ], [
                'giaTriToiThieu.interger' => "Giá trị tối thiểu phải là số",
                'giaTriToiThieu.min' => "Giá trị tối thiểu không thể nhỏ hơn 1",
            ]);
        }

        if ($request->filled('soLuong')) {
            $request->validate([
                'soLuong' => 'integer|min:1',
            ], [
                'soLuong.interger' => "Số lượng phải là số",
                'soLuong.min' => "Số lượng không thể nhỏ hơn 1",
            ]);
        }

        $discount->fill([
            'code' => $discount->code,
            'tenMa' => $request->tenMa,
            'hinhAnh' => $discount->hinhAnh,
            'moTa' => $request->moTa,
            'soLuong' => $request->filled('soLuong') ? $request->soLuong : null,
            'loaiKhuyenMai' => $discount->loaiKhuyenMai,
            'giaTriKhuyenMai' => $discount->giaTriKhuyenMai,
            'mucGiamToiDa' => $request->mucGiamToiDa,
            'ngayBatDau' => $discount->ngayBatDau,
            'ngayKetThuc' => $request->ngayKetThuc,
            'giaTriToiThieu' => $request->giaTriToiThieu,
        ]);
        $discount->save();

        if ($request->hasFile('hinhAnh')) {
            if ($discount->hinhAnh != 'images/no-image-available.jpg') {
                Storage::disk('public')->delete($discount->hinhAnh);
            }
            $discount->hinhAnh = $request->file('hinhAnh')->store('images/discount', 'public');
        }
        $discount->save();

        return Redirect::route('discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaGiamGia  $maGiamGia
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaGiamGia $discount)
    {
        if ($discount->hinhAnh != 'images/no-image-available.jpg') {
            Storage::disk('public')->delete($discount->hinhAnh);
        }

        $discount->delete();
        return Redirect::route('discount.index');
    }
}
