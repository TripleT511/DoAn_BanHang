<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BienTheSanPham;
use App\Models\TuyChonThuocTinh;
use App\Models\ThuocTinh;
use App\Models\TuyChonBienThe;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            foreach ($request->tieuDe as $key => $value) {
                $count = 0;

                foreach ($request->tieuDe as $key => $value2) {
                    if ($value == $value2) {
                        ++$count;
                    }
                    if ($count > 1) {
                        return back()->with("error2", "Tiêu đề thuộc tính là duy nhất không được trùng");
                    }
                }
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
        if ($request->has('tieuDe')) {
            foreach ($request->tieuDe as $key => $value) {
                $count = 0;

                foreach ($request->tieuDe as $key => $value2) {
                    if ($value == $value2) {
                        ++$count;
                    }
                    if ($count > 1) {
                        return back()->with("error2", "Tiêu đề thuộc tính là duy nhất không được trùng");
                    }
                }
            }
        } else {
            return back()->with("error2", "Giá trị thuộc tính bên dưới không được bỏ trống");
        }

        $lstNoneDelete = [];

        $lstTieuDe = $request->input('tieuDe');
        $lstmauSac = $request->input('mauSac');


        DB::beginTransaction();

        try {

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

            $lstOptionDelete = TuyChonThuocTinh::where('thuoc_tinh_id', $thuoctinh->id)->whereNotIn('id', $lstNoneDelete)->get();
            foreach ($lstOptionDelete as $item) {
                $checkMauSac = TuyChonThuocTinh::where('thuoc_tinh_id', 2)->get();
                $tuychonbienthe = TuyChonBienThe::where('tuy_chon_thuoc_tinh_id', $item->id)->get();
                foreach ($tuychonbienthe as $item2) {
                    $bienTheSanPham = BienTheSanPham::where('id', $item2->bien_the_san_pham_id)->first();
                    $bienTheSanPham->delete();
                    $item2->delete();
                }
                $item->delete();
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with("error2", "Không thể xoá toàn bộ màu sắc");
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
