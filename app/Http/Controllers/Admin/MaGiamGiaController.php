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

    public function indexRun()
    {
        $lstDiscount = MaGiamGia::where('ngayKetThuc', '>', date('Y-m-d', strtotime(date('Y-m-d') . " -1 days")))->orderBy('created_at', 'desc')->paginate(4)->withQueryString();

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
            'code.required' => 'M?? gi???m gi?? kh??ng ???????c b??? tr???ng',
            'tenMa.required' => "T??n m?? gi???m gi?? kh??ng ???????c b??? tr???ng",
            'moTa.required' => "M?? t??? kh??ng ???????c b??? tr???ng",
            'loaiKhuyenMai.required' => "Lo???i khuy???n m??i kh??ng ???????c b??? tr???ng",
            'giaTriKhuyenMai.required' => "Gi?? tr??? khuy???n m??i kh??ng ???????c b??? tr???ng",
            'ngayBatDau.required' => "Ng??y b???t ?????u b???t bu???c ch???n",
            'ngayBatDau.after_or_equal' => "Ng??y b???t ?????u kh??ng th??? nh??? h??n ng??y hi???n t???i",
            'ngayKetThuc.required' => "Ng??y k???t th??c b???t bu???c ch???n",
            'ngayKetThuc.after_or_equal' => "Ng??y k???t th??c kh??ng th??? nh??? h??n ng??y b???t ?????u",
        ]);

        if ($request->loaiKhuyenMai == 1) {
            $request->validate([
                'giaTriKhuyenMai' => 'integer|between:1,100',
            ], [
                'giaTriKhuyenMai.between' => "Gi?? tr??? khuy???n m??i t???i thi???u l?? 1 v?? t???i ??a 100",
            ]);
        }

        if ($request->filled('mucGiamToiDa')) {
            $request->validate([
                'mucGiamToiDa' => 'integer|min:1001',
            ], [
                'mucGiamToiDa.interger' => "M???c gi???m t???i ??a ph???i l?? s???",
                'mucGiamToiDa.min' => "M???c gi???m t???i ??a kh??ng th??? nh??? h??n 1000",
            ]);
        }

        if ($request->filled('giaTriToiThieu')) {
            $request->validate([
                'giaTriToiThieu' => 'integer|min:1',
            ], [
                'giaTriToiThieu.interger' => "Gi?? tr??? t???i thi???u ph???i l?? s???",
                'giaTriToiThieu.min' => "Gi?? tr??? t???i thi???u kh??ng th??? nh??? h??n 1",
            ]);
        }

        if ($request->filled('soLuong')) {
            $request->validate([
                'soLuong' => 'integer|min:1',
            ], [
                'soLuong.interger' => "S??? l?????ng ph???i l?? s???",
                'soLuong.min' => "S??? l?????ng kh??ng th??? nh??? h??n 1",
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
            'tenMa.required' => "T??n m?? gi???m gi?? kh??ng ???????c b??? tr???ng",
            'moTa.required' => "M?? t??? kh??ng ???????c b??? tr???ng",
            'ngayKetThuc.required' => "Ng??y k???t th??c b???t bu???c ch???n",
            'ngayKetThuc.after_or_equal' => "Ng??y k???t th??c kh??ng th??? nh??? h??n ng??y b???t ?????u",
        ]);


        if ($request->filled('mucGiamToiDa')) {
            $request->validate([
                'mucGiamToiDa' => 'integer|min:1001',
            ], [
                'mucGiamToiDa.interger' => "M???c gi???m t???i ??a ph???i l?? s???",
                'mucGiamToiDa.min' => "M???c gi???m t???i ??a kh??ng th??? nh??? h??n 1000",
            ]);
        }

        if ($request->filled('giaTriToiThieu')) {
            $request->validate([
                'giaTriToiThieu' => 'integer|min:1',
            ], [
                'giaTriToiThieu.interger' => "Gi?? tr??? t???i thi???u ph???i l?? s???",
                'giaTriToiThieu.min' => "Gi?? tr??? t???i thi???u kh??ng th??? nh??? h??n 1",
            ]);
        }

        if ($request->filled('soLuong')) {
            $request->validate([
                'soLuong' => 'integer|min:1',
            ], [
                'soLuong.interger' => "S??? l?????ng ph???i l?? s???",
                'soLuong.min' => "S??? l?????ng kh??ng th??? nh??? h??n 1",
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
