<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\HinhAnh;
use App\Models\SanPham;
use App\Models\User;
use App\Models\Slider;
use Dflydev\DotAccessData\Data;
use App\Models\LuotTimKiem;
use App\Jobs\SendMail2;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Svg\Tag\Rect;

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

            if (Auth()->user()->email_verified_at == null) {
                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Tài khoản chưa được xác nhận',
                ]);
            }
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

        return redirect()->route('admin.login');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
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

        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        
        return view('home', ['lstSanPham' => $lstSanPham, 'lstSanPhamNoiBat' => $lstSanPhamNoiBat, 'lstSlider' => $lstSlider, 'lstDanhMuc' => $lstDanhMuc]);
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
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $sanpham = SanPham::with('hinhanhs')->with('danhmuc')->where('slug', $slug)->first();
        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->where('san_pham_id', $sanpham->id)->get();
        $starActive = round($lstDanhGia->avg('xepHang'));
        $starNonActive = 5 - $starActive;
        $countRating = count($lstDanhGia);
        // Sản phẩm liên quan
        $lstDanhMucCon = DanhMuc::where('idDanhMucCha', $sanpham->danh_muc_id)->get();
        $lstIdDanhMucCon = [$sanpham->danh_muc_id];
        foreach ($lstDanhMucCon as $danhmuc)
            array_push($lstIdDanhMucCon, $danhmuc->id);

        $lstSanPhamLienQuan = SanPham::whereIn('danh_muc_id', $lstIdDanhMucCon)->with('hinhanhs')->with('danhmuc')->with('danhgias')->get();

        foreach ($lstSanPhamLienQuan as $key => $item) {
            if ($item->id == $sanpham->id) {
                // Loại bỏ sản phẩm trùng với sản phẩm đang xem
                $lstSanPhamLienQuan->forget($key);
            }
        }

        return view('product-detail', ['sanpham' => $sanpham, 'lstDanhGia' => $lstDanhGia, 'lstDanhMuc' => $lstDanhMuc, 'lstSanPhamLienQuan' => $lstSanPhamLienQuan, 'countRating' => $countRating, 'starActive' => $starActive, 'starNonActive' => $starNonActive]);
    }

    public function danhmucsanpham($slug)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        //
        $danhmucCha = DanhMuc::where('slug', $slug)->first();
        $lstDanhMucCon = DanhMuc::where('idDanhMucCha', $danhmucCha->id)->get();
        $lstIdDanhMucCon = [$danhmucCha->id];
        foreach ($lstDanhMucCon as $danhmuc)
            array_push($lstIdDanhMucCon, $danhmuc->id);
        $lstSanPham = SanPham::whereIn('danh_muc_id', $lstIdDanhMucCon)->with('hinhanhs')->with('danhmuc')->paginate(8);
        return view('san-pham', ['lstSanPham' => $lstSanPham, 'lstDanhMuc' => $lstDanhMuc]);
    }

    public function lstSanPham()
    {
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->paginate(8);
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        return view('san-pham', ['lstSanPham' => $lstSanPham, 'lstDanhMuc' => $lstDanhMuc]);
    }


    public function searchSP(Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstSanPham = SanPham::where('tenSanPham', 'LIKE', '%' . $request->keyword . '%')->with('hinhanhs')->with('danhmuc')->paginate(8);
        $soluong = Count(SanPham::where('tenSanPham', 'LIKE', '%' . $request->keyword . '%')->with('hinhanhs')->with('danhmuc')->get());
        if (empty($request->keyword)) {
        } elseif ($request->keyword == ' ') {
        } else {
            $kt = LuotTimKiem::where('tuKhoa', '=', $request->keyword)->first();
            if ($kt) {
                $kt->fill([
                    'soLuong' => $kt->soLuong + 1,
                ]);
                $kt->save();
            } else {
                $luottimkiem = LuotTimKiem::create([
                    'tuKhoa' => $request->keyword,
                    'soLuong' => '1',
                ]);
            }
        }
        return view('search', ['lstSanPham' => $lstSanPham, 'keyword' => $request->keyword, 'soluong' => $soluong,  'lstDanhMuc' => $lstDanhMuc]);
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
            'soDienThoai' => 'required|string|max:11|min:10',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'email.required' => 'Email không được bỏ trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'soDienThoai.min' => 'Số điện thoại không hợp lệ',
            'g-recaptcha-response.required' => 'Vui lòng xác nhận captcha',
        ]);
        $user = new User();
        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'soDienThoai' => $request->input('soDienThoai'),
            'phan_quyen_id' => '2',
            'anhDaiDien' => '',
            'diaChi' => ''
        ]);
        $user->save();

        return Redirect::route('user.login')->with('success', 'Vui lòng kiểm tra email để xác nhận tài khoản');
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

    public function xemThongTin()
    {
       
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        return view('user', ['lstDanhMuc' => $lstDanhMuc]);
    }

    public function changePass()
    {
        if(Auth()->user()->social_type != null) {
            return Redirect::back();
        }
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        return view('change-password', ['lstDanhMuc' => $lstDanhMuc]);
    }

    public function doimatkhau(Request $request)
    { 
       
        $request->validate([
            'password' => 'required',
            'newpassword' => 'required|min:6',
            'confirm_password' => 'required|same:newpassword',

        ], [
            'password.required' => 'Mật khẩu không được bỏ trống',
            'newpassword.required' => 'Mật khẩu mới không được bỏ trống',
            'newpassword.min' => 'Mật khẩu mới ít nhất 6 kí tự',
            'confirm_password.required' => 'Xác nhận mật khẩu không được bỏ trống',
            'confirm_password.same' => 'Xác nhận mật khẩu chưa trùng khớp',
        ]);

        $user = User::whereId($request->user)->first();

        if(!Hash::check($request->password,$user->password)){
            return Redirect::back()->withErrors(['password' => 'Mật khẩu cũ không đúng, vui lòng nhập lại']);
          }
      
        $user->fill([
            'password'=> Hash::make($request->newpassword),
        ]);
        $user->save();

        return Redirect::route('xem-thong-in-ca-nhan')->with('success', 'Đổi mật khẩu thành công');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $taiKhoan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
        $request->validate([
            'hoTen' => 'required|string|max:255',
            'soDienThoai' => 'required|string',
            'diaChi' => 'required|string',

        ], [
            'hoTen.required' => 'Họ Tên không được bỏ trống',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'diaChi.required' => 'Địa Chỉ không được bỏ trống',
        ]);

       
        $user = User::whereId($request->user)->first();
        
     

        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $user->email,
            'password' => $user->password,
            'anhDaiDien' => $user->anhDaiDien,
            'diaChi'=> $request->input('diaChi'),
            'soDienThoai' =>$request->input('soDienThoai'),
        ]);
        $user->save();

        if ($request->hasFile('anhDaiDien')) {
            $user->anhDaiDien = $request->file('anhDaiDien')->store('images/tai-khoan', 'public');
        }
        $user->save();
        
        return Redirect::route('xem-thong-in-ca-nhan')->with('success', 'Cập nhật thông tin cá nhân thành công');
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
