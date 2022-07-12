<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailReset;
use App\Jobs\SendEmailResetUser;
use App\Models\HoaDon;
use App\Models\LuotTimKiem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $lstLuotTimKiem = LuotTimKiem::orderBy('soLuong', 'desc')->limit(10)->get();
        $tongDoanhThu = DB::table("hoa_dons")->where([
            'trangThai' => 4,
            'trangThaiThanhToan' => 1
        ])->get()->sum("tongThanhTien");
        $tongSanPham = DB::table('san_phams')->get()->count();
        $tongHoaDon = DB::table('hoa_dons')->get()->count();
        $tongKhachHang = DB::table('users')->where('phan_quyen_id', 2)->whereNotNull('email_verified_at')->get()->count();

        return View('admin.dashboard', ['lstLuotTimKiem' => $lstLuotTimKiem, 'tongDoanhThu' => $tongDoanhThu, 'tongSanPham' => $tongSanPham, 'tongDonHang' => $tongHoaDon, 'tongKhachHang' => $tongKhachHang]);
    }

    public function thongKeDoanhThu(Request $request)
    {
        $doanhThu = [];
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach ($month as $value) {
            $hoadon = HoaDon::where([
                'trangThai' => 4,
                'trangThaiThanhToan' => 1
            ])->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $value)->sum('tongThanhTien');
            array_push($doanhThu, $hoadon);
        }
        return response()->json($doanhThu);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showFormForgot()
    {
        return view('admin.forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'email|required|exists:users',
        ], [
            'email.required' => "Bắt buộc nhập email",
            'email.email' => "Không đúng định dạng email",
            'email.exists' => "Email không tồn tại trong hệ thống",
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->social_id != null) {
            return redirect()->back()->with("error", "Trang này không dành cho tài khoản mạng xã hội");
        }

        $token = strtoupper(Str::random(60));
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        if ($user->phan_quyen_id == 2) {
            $this->dispatch(new SendEmailResetUser($user, $token));
        } else {
            $this->dispatch(new SendEmailReset($user, $token));
        }

        return redirect()->back()->with('message', 'Đã gửi email xác nhận');
    }

    public function formResetPassWord(Request $request)
    {
        return view('admin.reset-password', ['token' => $request->token]);
    }


    public function resetPassWord(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'confirm-password' => 'required|same:password',
            'token' => 'required|exists:password_resets',
        ], [

            'password.required' => "Bắt buộc nhập mật khẩu",
            'password.string' => "Mật khẩu phải là chuỗi ký tự",
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự",
            'confirm-password.required' => "Bắt buộc nhập lại mật khẩu",
            'confirm-password.same' => "Mật khẩu nhập lại không khớp",
            'token.required' => "Token không tồn tại",
            'token.exists' => "Token không tồn tại",
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'password.regex' => 'Mật khẩu tối thiểu 6 kí tự, bao gồm số, chữ hoa và chữ thường'
            ]);
        }

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        $formatDate =
            Carbon::parse($passwordReset->created_at)->addMinutes(5)->format('d/m/Y H:i:s');
        $now = Carbon::now()->format('d/m/Y H:i:s');

        $checkTime =  $now <= $formatDate ? true : false;
        if (!$checkTime) {
            DB::table('password_resets')->where('token', $request->token)->delete();
            return redirect()->back()->withErrors("error", "Token đã hết hạn");
        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->update();
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect()->route('admin.login')->with('message', 'Vui lòng đăng nhập');
    }


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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
