<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuyChonThuocTinh;
use App\Models\ThuocTinh;
use App\Models\TuyChonBienThe;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class ThuocTinhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $lstThuocTinh = ThuocTinh::paginate(5)->withQueryString();

        return View('admin.thuoctinh.index-thuoctinh', ['lstThuocTinh' => $lstThuocTinh]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.thuoctinh.create-thuoctinh');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->has('tieuDe')) {
            $request->validate([
                'tenThuocTinh' => 'required|unique:thuoc_tinhs,tenThuocTinh',
                'tieuDe.*' => 'required|unique:tuy_chon_thuoc_tinhs,tieuDe',

            ], [
                'tenThuocTinh.required' => "Tên thuộc tính không được bỏ trống",
                'tenThuocTinh.unique' => "Tên thuộc tính đã tồn tại",
                'tieuDe.*.required' => "Tiêu đề không được bỏ trống",
                'tieuDe.*.unique' => "Tiêu đề đã tồn tại",
            ]);
            if ($request->input('loaiThuocTinh') == "Color") {
                $request->validate([
                    'mauSac.*' => 'required',
                ], [
                    'mauSac.*.required' => "Màu sắc không được bỏ trống",

                ]);
            }
        } else {
            $request->validate([
                'tenThuocTinh' => 'required|unique:thuoc_tinhs,tenThuocTinh',
            ], [
                'tenThuocTinh.required' => "Tên thuộc tính không được bỏ trống",
                'tenThuocTinh.unique' => "Tên thuộc tính đã tồn tại",
            ]);
        }



        $thuoctinh = new ThuocTinh();

        $thuoctinh->fill([
            'tenThuocTinh' => $request->input('tenThuocTinh'),
            'loaiThuocTinh' => $request->input('loaiThuocTinh'),
        ]);

        $thuoctinh->save();

        $lstTieuDe = $request->input('tieuDe');
        $lstmauSac = $request->input('mauSac');

        foreach ($lstTieuDe as $key => $item) {
            $option = new TuyChonThuocTinh();

            $option->fill([
                'thuoc_tinh_id' => $thuoctinh->id,
                'tieuDe' => $lstTieuDe[$key],
                'mauSac' => $lstmauSac[$key] ?? ''
            ]);

            $option->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThuocTinh  $thuocTinh
     * @return \Illuminate\Http\Response
     */
    public function show(ThuocTinh $thuocTinh)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThuocTinh  $thuocTinh
     * @return \Illuminate\Http\Response
     */
    public function edit(ThuocTinh $thuoctinh)
    {
        $lstThuocTinh = ThuocTinh::all();
        $lstTuyChonThuocTinh = TuyChonThuocTinh::where('thuoc_tinh_id', $thuoctinh->id)->get();

        return view('admin.thuoctinh.edit-thuoctinh', ['thuoctinh' => $thuoctinh, 'lstTuyChonThuocTinh' => $lstTuyChonThuocTinh, 'lstThuocTinh' => $lstThuocTinh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThuocTinh  $thuocTinh
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThuocTinh $thuoctinh)
    {
        $request->validate([
            'tieuDe.*' => 'required',

        ], [
            'tieuDe.*.required' => "Tiêu đề không được bỏ trống",
        ]);
        if ($thuoctinh->loaiThuocTinh == "Color") {
            $request->validate([
                'mauSac.*' => 'required',
            ], [
                'mauSac.*.required' => "Màu sắc không được bỏ trống",

            ]);
        }

        $lstNoneDelete = [];
        $lstTieuDe = $request->input('tieuDe');
        $lstmauSac = $request->input('mauSac');

        foreach ($lstTieuDe as $key => $item) {

            if (isset($request->idOption[$key])) {
                $optionCurrent = TuyChonThuocTinh::where('id', $request->idOption[$key])->orWhere('tieuDe', $lstTieuDe[$key])->first();
                if ($optionCurrent) {
                    $optionCurrent->tieuDe = $lstTieuDe[$key];
                    $optionCurrent->mauSac = $lstmauSac[$key] ?? '';
                    $optionCurrent->save();

                    array_push($lstNoneDelete, $optionCurrent->id);
                }
            } else {
                $option = new TuyChonThuocTinh();

                $option->fill([
                    'thuoc_tinh_id' => $thuoctinh->id,
                    'tieuDe' => $lstTieuDe[$key],
                    'mauSac' => $lstmauSac[$key] ?? ''
                ]);

                $option->save();

                array_push($lstNoneDelete, $option->id);
            }
        }

        $lstOptionDelete = TuyChonThuocTinh::whereNotIn('id', $lstNoneDelete)->get();
        foreach ($lstOptionDelete as $item) {
            $item->delete();
        }

        return Redirect::route('thuoctinh.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThuocTinh  $thuocTinh
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThuocTinh $thuocTinh)
    {
        //
    }
}
