<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DanhMuc;
use App\Http\Requests\StoreDanhMucRequest;
use App\Http\Requests\UpdateDanhMucRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listDanhMuc = DanhMuc::with('childs')->get();

        return view('admin.danhmuc.index-danhmuc', ['lstDanhMuc' => $listDanhMuc]);
    }

    public function getDanhMucSanPham()
    {
        $lstdanhMuc =
            DanhMuc::orderBy('slug', 'desc')->get();

        $lstDanhMucNew = [];
        DanhMuc::dequyDanhMuc($lstdanhMuc, $idDanhMucCha = 0, $level = 1, $lstDanhMucNew);
        return $lstDanhMucNew;
    }

    public function searchDanhMuc(Request $request)
    {
        $output = "";

        if ($request->input('txtSearch') != "") {
            $lstDanhMuc = DanhMuc::where('tenDanhMuc', 'LIKE', '%' . $request->input('txtSearch') . '%')->get();
            foreach ($lstDanhMuc as $key => $item) {             
                $output .= '
                <tr>
                 <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>'. $char . $item->tenDanhMuc .'</strong></td>
                 <td><i class="fab fa-angular fa-lg text-danger me-3"></i> '. $item->idDanhMucCha .'</td>
                       <td>
                          <a class="btn btn-success" href="'. route('danhmuc.edit', ['danhmuc' => $item]) .'">
                            <i class="bx bx-edit-alt me-1"></i>Sửa
                          </a>
                          <form class="d-inline-block" method="post" action="'. route('danhmuc.destroy', ['danhmuc'=>$item]) .'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Xoá</button>
                          </form>
                        </td>
              </tr>
                ';
            }
        }
        return response()->json($output);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listDanhMucCha = DanhMuc::orderBy('slug', 'desc')->get();
        return view('admin.danhmuc.create-danhmuc', ['danhMucCha' => $listDanhMucCha]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDanhMucRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDanhMucRequest $request)
    {
        $request->validate([
            'tenDanhMuc' => 'required|unique:danh_mucs',
        ], [
            'tenDanhMuc.required' => "Tên danh mục không được bỏ trống",
            'tenDanhMuc.unique' => 'Tên danh mục không được trùng',
        ]);

        $danhmuc = new DanhMuc();
        $idDanhMucCha = $request->input('idDanhMucCha') != 0 ? $request->input('idDanhMucCha') : null;

        $slug = '';
        if ($request->filled('slug')) {
            $slug = $request->input('slug');
        } else {
            $slug = Str::of($request->input('tenDanhMuc'))->slug('-');
        }

        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $slug,
            'idDanhMucCha' => $idDanhMucCha,
        ]);

        $danhmuc->save();


        return Redirect::route('danhmuc.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function show(DanhMuc $danhMuc)
    {
        return $danhMuc;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function edit(DanhMuc $danhmuc)
    {
        $listDanhMucCha = DanhMuc::orderBy('id', 'desc')->get();
        return view('admin.danhmuc.edit-danhmuc', ['danhmuc' => $danhmuc, 'danhMucCha' => $listDanhMucCha]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDanhMucRequest  $request
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDanhMucRequest $request, DanhMuc $danhmuc)
    {
        $request->validate([
            'tenDanhMuc' => 'required',
            'slug' => 'required',

        ], [
            'tenSanPham.required' => "Tên sản phẩm không được bỏ trống",
            'slug.required' => "Slug không được bỏ trống"
        ]);
        $idDanhMucCha = $request->input('idDanhMucCha') != null ? $request->input('idDanhMucCha') : 0;
        $danhmuc->fill([
            'tenDanhMuc' => $request->input('tenDanhMuc'),
            'slug' => $request->input('slug'),
            'idDanhMucCha' => $idDanhMucCha,
        ]);

        $danhmuc->save();
        return Redirect::route('danhmuc.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DanhMuc  $danhMuc
     * @return \Illuminate\Http\Response
     */
    public function destroy(DanhMuc $danhmuc)
    {
        $danhmuc->delete();
        return Redirect::route('danhmuc.index');
    }
}
