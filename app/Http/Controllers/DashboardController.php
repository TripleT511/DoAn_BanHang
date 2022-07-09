<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\LuotTimKiem;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ])->get()->sum("tongTien");
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
            ])->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $value)->sum('tongTien');
            array_push($doanhThu, $hoadon);
        }
        return response()->json($doanhThu);
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
