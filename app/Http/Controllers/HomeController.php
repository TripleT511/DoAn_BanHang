<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\HinhAnh;
use App\Models\SanPham;
use App\Models\User;
use App\Models\Slider;
use App\Models\LuotTimKiem;
use App\Jobs\SendMail2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function fixImage(HinhAnh $hinhAnh)
    {
        if (Storage::disk('public')->exists($hinhAnh->hinhAnh)) {
            $hinhAnh->hinhAnh = $hinhAnh->hinhAnh;
        } else {
            $hinhAnh->hinhAnh = 'images/no-image-available.jpg';
        }
    }
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

            return redirect()->intended('admin/dashboard');
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

    public function danhmucsanpham($slug)
    {
    }

    public function lstSanPham()
    {
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->paginate(5);
        return view('san-pham', ['lstSanPham' => $lstSanPham]);
    }


    public function searchSP(Request $request)
    {
        $lstSanPham = SanPham::where('tenSanPham', 'LIKE', '%' . $request->keyword . '%')->with('hinhanhs')->with('danhmuc')->paginate(8);
        $soluong = Count(SanPham::where('tenSanPham', 'LIKE', '%' . $request->keyword . '%')->with('hinhanhs')->with('danhmuc')->get());
        if(empty($request->keyword)){}
        elseif($request->keyword== ' '){}
        else{
        $kt = LuotTimKiem::where('tuKhoa','=',$request->keyword)->first(); 
        if($kt){
            $kt->fill([
                'soLuong'=> $kt->soLuong+1,
            ]);$kt->save();
        }else{
                $luottimkiem=LuotTimKiem::create([
                'tuKhoa'=>$request->keyword,
                'soLuong'=> '1',
                ]);
            }
        }
        return view('search', ['lstSanPham' => $lstSanPham, 'keyword' => $request->keyword, 'soluong' => $soluong]);
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
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'soDienThoai' => 'required|string|max:10|min:10',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'g-recaptcha-response.required'=>'chua nhan kiem tra',
        ]);
        $user = new User();
        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'soDienThoai' => $request->input('soDienThoai'),
            'phan_quyen_id' => '2',
            'anhDaiDien' => ''
        ]);
        $user->save();

        if ($request->hasFile('anhDaiDien')) {
            $user->anhDaiDien = $request->file('anhDaiDien')->store('images/tai-khoan/', 'public');
        }
        $user->save();
        return Redirect::route('home');
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
