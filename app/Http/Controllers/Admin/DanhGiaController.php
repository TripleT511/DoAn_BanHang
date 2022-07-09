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
        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->orderBy('created_at', 'desc')->paginate(5);
        return View('admin.danhgia.index-danhgia', ['lstDanhGia' => $lstDanhGia]);
    }
    public function searchDanhGia(Request $request)
    {
        $stringSearch = $request->input('keyword');

        if ($request->input('keyword') != "") {
            $lstDanhGia = DanhGia::with('sanpham')->whereHas('sanpham', function ($query) use ($stringSearch) {
                return $query->where('tenSanPham', 'LIKE', '%' . $stringSearch . '%');
            })->with('taikhoan')->orWhereHas('taikhoan', function ($query) use ($stringSearch) {
                return $query->where('hoTen', 'LIKE', '%' . $stringSearch . '%');
            })->paginate(5);
        }
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
                'user_id' => 'required',
                'noiDung' => 'required',
                'xepHang' => 'required|min:1|max:5',
            ],
            [
                'sanphamId.required' => "Không tìm thấy sản phẩm",
                'user_id.required' => "Vui lòng đăng nhập để thực hiện chức năng này",
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

        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->where('san_pham_id', $request->sanphamId)->orderBy('created_at', 'desc')->get();

        $countDanhGia = $lstDanhGia->count();
        $avgDanhGia = round($lstDanhGia->avg('xepHang'));

        $outputMain1 = "";
        $outputMain2 = "";

        $starActive = round($avgDanhGia);
        $starNonActive = 5 - $starActive;
        for ($i = 0; $i < $starActive; $i++) {
            $outputMain1 .= ' <i class="icon-star voted"></i>';
            $outputMain2 .= ' <i class="icon-star"></i>';
        }
        for ($i = 0; $i < $starNonActive; $i++) {
            $outputMain1 .= '<i class="icon-star"></i>';
            $outputMain2 .= ' <i class="icon-star empty"></i>';
        }





        foreach ($lstDanhGia as $key => $item) {
            $starActive = $item->xepHang;
            $starNonActive = 5 - $item->xepHang;
            $star1 = "";
            $star2 = "";
            for ($i = 0; $i < $starActive; $i++) {
                $star1 .= '<i class="icon-star"></i>';
            }
            for ($i = 0; $i < $starNonActive; $i++) {
                $star2 .= '<i class="icon-star empty"></i>';
            }
            $output .= '
                <div class="col-lg-6">
                    <div class="review_content">
                        <div class="clearfix add_bottom_10">
                            <span class="rating">
                            ' .
                $star1 . $star2
                . '
                            </i>
                            </span>
                            <em>' . date('d-m-Y', strtotime($item->created_at)) . '</em>
                        </div>
                        <h4>' . $item->taikhoan->hoTen . '</h4>
                        <p>' . $item->noiDung . '</p>
                        ' . Auth()->user()->id == $item->user_id ? '<a href="" class="btn btn-danger" data-id="' . $item->id . '</a>Xoá</a>' : '' . '
                    </div>
                </div>
            ';
        }

        return response()->json([
            'success' => "Đánh giá sản phẩm thành công",
            'output' => $output,
            'outputMain1' => $outputMain1,
            'outputMain2' => $outputMain2,
            'avg' => $avgDanhGia,
            'count' => $countDanhGia
        ]);
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
