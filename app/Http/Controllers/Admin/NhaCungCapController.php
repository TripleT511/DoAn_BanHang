<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\NhaCungCap;
use App\Http\Requests\StoreNhaCungCapRequest;
use App\Http\Requests\UpdateNhaCungCapRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstNCC = NhaCungCap::paginate(5)->withQueryString();
        return View('admin.nhacungcap.index-nhacungcap', ['lstNCC' => $lstNCC]);
    }

    public function searchNCC(Request $request)
    {
        $output = "";

        if ($request->input('txtSearch') != "") {
            $lstNCC = NhacungCap::where('tenNhaCungCap', 'LIKE', '%' . $request->input('txtSearch') . '%')->get();
            foreach ($lstNCC as $key => $item) {
                $output .= '
                <tr>
                 <td><strong>' . $item->tenNhaCungCap . '</strong></td>
                 <td> ' . $item->soDienThoai . ' </td>
                 <td>  ' . $item->email . ' </td>
                 <td> ' . $item->diaChi . '</td>
                 <td>
                  <a class="btn btn-success" href="' . route('nhacungcap.edit', ['nhacungcap' => $item]) . '">
                    <i class="bx bx-edit-alt me-1"></i>Sửa
                  </a>
                 <form class="d-inline-block" method="post" action="' . route('nhacungcap.destroy', ['nhacungcap' => $item]) . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
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

        return view('admin.nhacungcap.create-nhacungcap');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNhaCungCapRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNhaCungCapRequest $request)
    {
        $request->validate([
            'tenNhaCungCap' => 'required|unique:nha_cung_caps',
            'soDienThoai' => 'required',
            'email' => 'required|email',
            'diaChi' => 'required',
        ], [
            'tenNhaCungCap.required' => "Tên nhà cung cấp không được bỏ trống",
            'tenNhaCungCap.unique' => "Tên nhà cung cấp đã tồn tại",
            'soDienThoai.required' => "Số điện thoại không được bỏ trống",
            'email.required' => "Email không được bỏ trống",
            'email.email' => "Email không đúng định dạng",
            'diaChi.required' => "Địa chỉ không được bỏ trống",
        ]);

        $nhacungcap = new NhaCungCap();
        $nhacungcap->fill([
            'tenNhaCungCap' => $request->input('tenNhaCungCap'),
            'soDienThoai' => $request->input('soDienThoai'),
            'email' => $request->input('email'),
            'diaChi' => $request->input('diaChi'),
        ]);
        $nhacungcap->save();
        return Redirect::route('nhacungcap.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NhaCungCap  $nhaCungCap
     * @return \Illuminate\Http\Response
     */
    public function show(NhaCungCap $nhaCungCap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NhaCungCap  $nhaCungCap
     * @return \Illuminate\Http\Response
     */
    public function edit(NhaCungCap $nhacungcap)
    {
        return view('admin.nhacungcap.edit-nhacungcap', ['nhacungcap' => $nhacungcap]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNhaCungCapRequest  $request
     * @param  \App\Models\NhaCungCap  $nhaCungCap
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNhaCungCapRequest $request, NhaCungCap $nhacungcap)
    {
        $request->validate([
            'tenNhaCungCap' => 'required',
            'soDienThoai' => 'required',
            'email' => 'required|email',
            'diaChi' => 'required',
        ], [
            'tenNhaCungCap.required' => "Tên nhà cung cấp không được bỏ trống",
            'soDienThoai.required' => "Số điện thoại không được bỏ trống",
            'email.required' => "Email không được bỏ trống",
            'email.email' => "Email không đúng định dạng",
            'diaChi.required' => "Địa chỉ không được bỏ trống",
        ]);

        if ($request->tenNhaCungCap != $nhacungcap->tenNhaCungCap) {
            $request->validate([
                'tenNhaCungCap' => 'unique:nha_cung_caps',
            ], [
                'tenNhaCungCap.unique' => "Tên nhà cung cấp đã tồn tại",
            ]);
        }

        $nhacungcap->fill([
            'tenNhaCungCap' => $request->input('tenNhaCungCap'),
            'soDienThoai' => $request->input('soDienThoai'),
            'email' => $request->input('email'),
            'diaChi' => $request->input('diaChi'),
        ]);
        $nhacungcap->save();
        return Redirect::route('nhacungcap.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NhaCungCap  $nhaCungCap
     * @return \Illuminate\Http\Response
     */
    public function destroy(NhaCungCap $nhacungcap)
    {
        $nhacungcap->delete();
        return Redirect::route('nhacungcap.index');
    }
}
