<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\DanhGia;
use App\Models\SanPham;
use App\Models\User;
use App\Http\Requests\StoreDanhGiaRequest;
use App\Http\Requests\UpdateDanhGiaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->get();
        return View('admin.danhgia.index-danhgia',['lstDanhGia'=> $lstDanhGia]);
       
    }
    public function searchBinhLuan(Request $request)
    {
        $output = "";

       $stringSearch = $request->input('txtSearch');
        
        if ($request->input('txtSearch') != "") {
            $lstDanhGia = DanhGia::with('sanpham')->whereHas('sanpham', function ($query) use ($stringSearch) {
                return $query->where('tenSanPham', 'LIKE', '%' .$stringSearch . '%');
            })->with('taikhoan')->orWhereHas('taikhoan', function ($query) use ($stringSearch) {
                return $query->where('hoTen', 'LIKE', '%' .$stringSearch . '%');
            })->get();

            foreach ($lstDanhGia as $key => $item) {             

                $output .= '
                <tr>
                </td>
                  <td><strong>'. $item->sanpham->tenSanPham .'</strong>
                </td>
                </td>
                  <td><strong>'. $item->taikhoan->hoTen .'</strong>
                </td>
                </td>
                  <td><strong>'. $item->noiDung .'</strong>
                </td>
                </td>
                  <td><strong>'. $item->xepHang .'</strong>
                </td>
                <td>
                <form class="d-inline-block" method="post" action="'.route('danhgia.destroy', ['danhgium' => $item]).'">
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
        return View('admin.danhgia.create-danhgia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDanhGiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDanhGiaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function show(DanhGia $danhgia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function edit(DanhGia $danhgia)
    {
        return View('admin.danhgia.edit-danhgia');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDanhGiaRequest  $request
     * @param  \App\Models\DanhGia  $danhGia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDanhGiaRequest $request, DanhGia $danhgia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DanhGia  $danhgia
     * @return \Illuminate\Http\Response
     */
    public function destroy(DanhGia $danhgia)
    {
        $danhgia-> delete();
        return Redirect::route('danhgia.index');
    }
}
