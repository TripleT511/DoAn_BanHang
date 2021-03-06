<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailReset;
use App\Jobs\SendEmailResetUser;
use App\Models\HoaDon;
use App\Models\LuotTimKiem;
use App\Models\SanPham;
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

        $lstSanPham = SanPham::with('hinhanhs')->with('sizes')->withSum('sizes', 'soLuong')->orderBy('sizes_sum_so_luong')->take(5)->get();


        return View('admin.dashboard', ['lstLuotTimKiem' => $lstLuotTimKiem, 'tongDoanhThu' => $tongDoanhThu, 'tongSanPham' => $tongSanPham, 'tongDonHang' => $tongHoaDon, 'tongKhachHang' => $tongKhachHang, 'lstSanPham' => $lstSanPham]);
    }

    public function sanPhamHetHang(Request $request)
    {
        $data = "";
        switch ($request->type) {
            case 'top5':
                $data = SanPham::with('hinhanhs')->with('sizes')->withSum('sizes', 'soLuong')->orderBy('sizes_sum_so_luong')->take(5)->get();
                break;
            case 'top10':
                $data = SanPham::with('hinhanhs')->with('sizes')->withSum('sizes', 'soLuong')->orderBy('sizes_sum_so_luong')->take(10)->get();
                break;
            case 'top15':
                $data = SanPham::with('hinhanhs')->with('sizes')->withSum('sizes', 'soLuong')->orderBy('sizes_sum_so_luong')->take(15)->get();
                break;
            default:
                $data = SanPham::with('hinhanhs')->with('sizes')->withSum('sizes', 'soLuong')->orderBy('sizes_sum_so_luong')->take(5)->get();
                break;
        }

        $output = "";
        $count = 0;
        foreach ($data as $key => $item) {
            $hinhAnh = "";
            foreach ($item->hinhanhs as $key => $item2) {
                if ($key == 1) break;
                $hinhAnh = $item2->hinhAnh;
            }

            $output .= '
                <tr>
                <td>' . ++$count . '</td>
                        <td>
                          <div class="img">
                            <img src="' . asset('storage/' . $hinhAnh) . '" class="image-product" alt="' . $item->tenSanPham . '">
                          </div>
                        </td>
                        <td style="width: 20%;"><strong>
                          <a href="' . route('chitietsanpham', ['slug' => $item->slug]) . '" target="_blank">
                          ' . $item->tenSanPham . '
                        </a>  
                        </strong>
                        </td>
                        <td>
                          ' . $item->sizes_sum_so_luong . '
                        </td>
                      </tr>
            ';
        }
        return response()->json([
            'success' => "L???y d??? li???u th??nh c??ng",
            'data' => $output
        ]);
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
            'email.required' => "B???t bu???c nh???p email",
            'email.email' => "Kh??ng ????ng ?????nh d???ng email",
            'email.exists' => "Email kh??ng t???n t???i trong h??? th???ng",
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && $user->social_id != null) {
            return redirect()->back()->with("error", "Trang n??y kh??ng d??nh cho t??i kho???n m???ng x?? h???i");
        } else {
            return redirect()->back()->with("error", "T??i kho???n n??y kh??ng t???n t???i ho???c ???? b??? xo??");
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

        return redirect()->back()->with('message', '???? g???i email x??c nh???n');
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

            'password.required' => "B???t bu???c nh???p m???t kh???u",
            'password.string' => "M???t kh???u ph???i l?? chu???i k?? t???",
            'password.min' => "M???t kh???u ph???i c?? ??t nh???t 6 k?? t???",
            'confirm-password.required' => "B???t bu???c nh???p l???i m???t kh???u",
            'confirm-password.same' => "M???t kh???u nh???p l???i kh??ng kh???p",
            'token.required' => "Token kh??ng t???n t???i",
            'token.exists' => "Token kh??ng t???n t???i",
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'password.regex' => 'M???t kh???u t???i thi???u 6 k?? t???, bao g???m s???, ch??? hoa v?? ch??? th?????ng'
            ]);
        }

        $passwordReset = DB::table('password_resets')->where('token', $request->token)->first();

        $formatDate =
            Carbon::parse($passwordReset->created_at)->addMinutes(5)->format('d/m/Y H:i:s');
        $now = Carbon::now()->format('d/m/Y H:i:s');

        $checkTime =  $now <= $formatDate ? true : false;
        if (!$checkTime) {
            DB::table('password_resets')->where('token', $request->token)->delete();
            return redirect()->back()->withErrors("error", "Token ???? h???t h???n");
        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->update();
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect()->route('admin.login')->with('message', 'Vui l??ng ????ng nh???p');
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
