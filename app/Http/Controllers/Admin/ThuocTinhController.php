<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TuyChonThuocTinh;
use App\Models\ThuocTinh;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ThuocTinhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllThuocTinh()
    {
        $lstThuocTinh = ThuocTinh::all();
        $output = "";

        foreach ($lstThuocTinh as $key => $item) {
            $output .= '
            <option id="' . $item->id . '" class="attr-id-' . $item->id . '" value="' . $item->tenThuocTinh . '"></option>
            ';
        }


        return response()->json($output);
    }

    public function addThuocTinh(Request $request)
    {
        $lstThuocTinh = Session::get("lstThuocTinh");
        $thuoctinh = ThuocTinh::where('tenThuocTinh', $request->tenThuocTinh)->first();
        $lstThuocTinh[$thuoctinh->tenThuocTinh] = array(
            "id" => $thuoctinh->id,
            "tenThuocTinh" => $thuoctinh->tenThuocTinh,
            "loai" => $thuoctinh->loaiThuocTinh
        );
        Session::put("lstThuocTinh", $lstThuocTinh);

        $lstNewThuocTinh =
            Session::get("lstThuocTinh");
        $output = '';
        foreach ($lstNewThuocTinh as $value => $item) {
            $output .= '<div class="attr-item d-flex align-items-center">
                            <i class="bx bx-radio-circle"></i>
                            ' . $item['tenThuocTinh'] . '
                            <button type="button" class="btn btn-outline-success d-flex align-items-center" style="gap: 5px"><i class="bx bxs-plus-circle"></i> Thêm </button>
                            <button type="button" class="btn btn-outline-danger d-flex align-items-center" style="gap: 5px"><i class="bx bx-trash"></i> Xoá</button>
                        </div>';
        }

        return response()->json($output);
    }
    public function index()
    {
        $lstThuocTinh = ThuocTinh::all();

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


        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tenThuocTinh'))->slug('-');
        }

        $thuoctinh = new ThuocTinh();

        $thuoctinh->fill([
            'tenThuocTinh' => $request->input('tenThuocTinh'),
            'loaiThuocTinh' => $request->input('loaiThuocTinh'),
            'slug' => $slug
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
        dd($request);
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
