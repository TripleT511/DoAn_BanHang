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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DanhGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstDanhGia = DanhGia::with('sanphams')->with('taikhoan')->get();
        return View('admin.danhgia.index-danhgia', ['lstDanhGia' => $lstDanhGia]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'sanphamId' => 'required',
                'user_id' => 'required|unique:danh_gias,user_id',
                'noiDung' => 'required',
                'xepHang' => 'required|min:1|max:5',
            ],
            [
                'sanphamId.required' => "Không tìm thấy sản phẩm",
                'user_id.required' => "Vui lòng đăng nhập để thực hiện chức năng này",
                'user_id.unique' => "Bạn đã đánh giá sản phẩm này rồi",
                'noiDung.required' => "Nội dung không được bỏ trống",
                'xepHang.required' => "Cần chọn sao đánh giá",
            ]
        );

        if ($validator->fails()) {
            $error = '';
            foreach ($validator->errors()->all() as $item) {
                $error .= '
                    <li class="card-description" style="color: #fff;">' . $item . '</li>
                ';
            }
            return response()->json(['error' => $error]);
        }

        $danhgia = new DanhGia();

        $danhgia->fill([
            'san_pham_id' => $request->sanphamId,
            'user_id' => $request->user_id,
            'noiDung' => $request->noiDung,
            'xepHang' => $request->xepHang
        ]);

        $danhgia->save();

        $output = "";

        $lstDanhGia = DanhGia::with('sanphams')->with('taikhoan')->where('san_pham_id', $request->sanphamId)->get();

        foreach ($lstDanhGia as $key => $item) {
            $output .= '
                <div class="col-lg-6">
                    <div class="review_content">
                        <div class="clearfix add_bottom_10">
                            <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><em>5.0/5.0</em></span>
                            <em>Published 54 minutes ago</em>
                        </div>
                        <h4>' . $item->taikhoan->hoTen . '</h4>
                        <p>' . $item->noiDung . '</p>
                    </div>
                </div>
            ';
        }

        return response()->json(['success' => "Đánh giá sản phẩm thành công", 'output' => $output]);
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
        $danhgia->delete();
        return Redirect::route('danhgia.index');
    }
}
