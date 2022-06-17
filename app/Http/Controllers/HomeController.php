<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\SanPham;
use App\Models\User;
use App\Models\Slider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function renderCart()
    {
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => "Bắt buộc nhập email",
            'email.email' => "Không đúng định dạng email",
            'password.required' => "Bắt buộc nhập mật khẩu"
        ]);


        $remember = $request->has('nhomatkhau') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,], $remember)) {

            $request->session()->regenerate();

            if (Auth()->user()->phan_quyen_id == 2) {
                return redirect()->route('home');
            }

            return redirect()->intended('/admin');
        }


        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('adminlogin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstSlider = Slider::all();

        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->get();

        $lstSanPhamNoiBat = SanPham::with('hinhanhs')->with('danhmuc')->take(8)->get();


        return view('home', ['lstSanPham' => $lstSanPham, 'lstSanPhamNoiBat' => $lstSanPhamNoiBat, 'lstSlider' => $lstSlider]);
    }

    public function danhgia()
    {

        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->get();

        $lstSanPhamNoiBat = SanPham::with('hinhanhs')->with('danhmuc')->take(8)->get();


        return view('review', ['lstSanPham' => $lstSanPham, 'lstSanPhamNoiBat' => $lstSanPhamNoiBat]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sanpham($slug)
    {
        $sanpham = SanPham::with('hinhanhs')->with('danhmuc')->where('slug', $slug)->first();
        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->where('san_pham_id', $sanpham->id)->get();
        return view('product-detail', ['sanpham' => $sanpham, 'lstDanhGia' => $lstDanhGia]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function show(User $taiKhoan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function edit(User $taiKhoan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $taiKhoan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaiKhoan  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $taiKhoan)
    {
        //
    }
}
