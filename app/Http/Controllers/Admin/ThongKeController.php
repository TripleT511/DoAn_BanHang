<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\LuotTimKiem;
use App\Models\SanPham;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ThongKeController extends Controller
{
    public function index()
    {
        $doanhThu = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

        $top5SanPhamBanChay = SanPham::with('chitiethoadons.hoadonSuccess')->withSum(['chitiethoadons' => function ($query) {
            $query->with('hoadon')->whereHas('hoadon', function ($query) {
                $query->where('trangThai', 4);
            });
        }], 'soLuong')->withCount(['chitiethoadons' => function ($query) {
            $query->with('hoadon')->whereHas('hoadon', function ($query) {
                $query->where('trangThai', 4);
            });
        }], 'hoa_don_id')->orderBy('chitiethoadons_sum_so_luong', 'desc')->take(5)->get();

        $tongDoanhThu = $doanhThu->sum("tongThanhTien");
        $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->get()->count();
        $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->get()->count();


        return View('admin.thongke', [
            'doanhThuAfter7Days' => $doanhThu,
            'top5SanPhamBanChay' => $top5SanPhamBanChay,
            'tongDoanhThu' => $tongDoanhThu,
            'tongSanPham' => $tongSanPham,
            'tongDonHang' => $tongHoaDon,
        ]);
    }

    public function doanhThuAfter7Days()
    {
        $lstLabel = [];
        for ($i = 6; $i >= 1; $i--) {
            $time = Carbon::now()->subDays($i);
            array_push(
                $lstLabel,
                $time
            );
        }

        array_push(
            $lstLabel,
            Carbon::now()
        );
        $lstData = [];
        foreach ($lstLabel as $key => $value) {
            $doanhThu = HoaDon::with('chiTietHoaDons')->whereDate('created_at', $value)->where('trangThai', 4)->sum('tongTien');
            array_push($lstData, $doanhThu);
            $lstLabel[$key] =
                $value->format('d/m');
        }

        return response()->json([
            'labels' => $lstLabel,
            'data' => $lstData,
        ]);
    }

    public function thongKeTopSanPhamBanChay(Request $request)
    {
        $data = "";
        switch ($request->type) {
            case 'top5':
                $data =
                    SanPham::with('chitiethoadons.hoadonSuccess')->withSum(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'soLuong')->withCount(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'hoa_don_id')->orderBy('chitiethoadons_sum_so_luong', 'desc')->take(5)->get();
                break;
            case 'top10':
                $data =
                    SanPham::with('chitiethoadons.hoadonSuccess')->withSum(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'soLuong')->withCount(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'hoa_don_id')->orderBy('chitiethoadons_sum_so_luong', 'desc')->take(10)->get();
                break;
            case 'top15':
                $data =
                    SanPham::with('chitiethoadons.hoadonSuccess')->withSum(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'soLuong')->withCount(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'hoa_don_id')->orderBy('chitiethoadons_sum_so_luong', 'desc')->take(15)->get();
                break;
            default:
                $data =
                    SanPham::with('chitiethoadons.hoadonSuccess')->withSum(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'soLuong')->withCount(['chitiethoadons' => function ($query) {
                        $query->with('hoadon')->whereHas('hoadon', function ($query) {
                            $query->where('trangThai', 4);
                        });
                    }], 'hoa_don_id')->orderBy('chitiethoadons_sum_so_luong', 'desc')->take(5)->get();
                break;
        }
        $output = "";
        $tongSoLuongSanPham = 0;
        $tongThanhTien = 0;
        $tongDonHang = 0;
        foreach ($data as $key => $item) {
            $thanhTien = 0;
            $soLuong = ($item->chitiethoadons_sum_so_luong) ? $item->chitiethoadons_sum_so_luong : 0;
            $donHang = ($item->chitiethoadons_count) ? $item->chitiethoadons_count : 0;
            $thanhTien = $soLuong * $item->gia;
            $tongSoLuongSanPham += $soLuong;
            $tongThanhTien += $thanhTien;
            $tongDonHang += $donHang;
            $output .= '
                <tr>
                    <td class="text-left">
                        ' . ++$key . '
                    </td class="text-left">
                    <td>
                        <a href="' . route('chitietsanpham', ['slug' => $item->slug]) . '" class="text-primary" target="_blank" title="' . $item->tenSanPham . '">
                            ' . $item->tenSanPham . '
                        </a>
                    </td>
                    <td class="text-right">
                        ' . $soLuong . '
                    </td>
                    <td class="text-right">
                        ' . number_format($thanhTien, 0, '', ',') . ' ₫
                    </td>
                    <td class="text-right">
                        ' . $donHang . '
                    </td>
                    </tr>
            ';
        }
        $output .= '
            <tr>
                <td><strong>Tổng:</strong></td>
                <td></td>
                <td class="text-right"><strong>' . $tongSoLuongSanPham . '</strong></td>
                <td class="text-right"><strong>' . number_format($tongThanhTien, 0, '', ',') . ' ₫</strong></td>
                <td class="text-right"><strong>' . $tongDonHang . '</strong></td>
            </tr>
        ';

        return response()->json([
            'success' => "Lấy dữ liệu thành công",
            'data' => $output
        ]);
    }


    public function khoangThoiGian(Request $request)
    {
        $data = '';
        $period = "";
        $lstDate = [];
        $hoadonDaXuLy = "";
        $hoadonDangXuLy = "";
        $hoadonDaHuy = "";

        $tongSanPham = "";
        $tongHoaDon = "";
        switch ($request->type) {
            case 'today':
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //

                $tongSanPham = DB::table('san_phams')->whereDate('created_at', Carbon::now())->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->get()->count();
                // *** Thống Kê Số Lượng *** //


                break;
            case 'yesterday':
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now()->subDays(1))->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now()->subDays(1))->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now()->subDays(1))->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now()->subDays(1))->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereDate('created_at', Carbon::now()->subDays(1))->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereDate('created_at', Carbon::now()->subDays(1))->get()->count();
                // *** Thống Kê Số Lượng *** //

                break;
            case 'last7days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }

                break;
            case 'last30days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'last90days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //
                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'lastmonth':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'lastyear':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subYear(1)->startOfYear(), Carbon::now()->subYear(1)->endOfYear()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'thisyear':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //

                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get()->count();
                // *** Thống Kê Số Lượng *** //

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            default:
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

                // *** Biểu đồ tròn *** //
                $hoadonDaXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->count();
                $hoadonDangXuLy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->whereIn('trangThai', [0, 1, 2, 3])->count();
                $hoadonDaHuy = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->where('trangThai', 5)->count();
                // *** Biểu đồ tròn *** //
                // *** Thống Kê Số Lượng *** //
                $tongSanPham = DB::table('san_phams')->whereDate('created_at', Carbon::now())->get()->count();
                $tongHoaDon = DB::table('hoa_dons')->whereDate('created_at', Carbon::now())->get()->count();
                // *** Thống Kê Số Lượng *** //
                break;
        }



        $output = "";


        $tongSLDonHang = 0;
        $tongDoanhThuDonHang = 0;
        $tongGiamGiaDonHang = 0;
        $tongDoanhThu = 0;
        foreach ($data as $item) {
            $tongSLDonHang += $item->chi_tiet_hoa_dons_sum_so_luong;
            $tongDoanhThuDonHang += $item->tongTien;
            $tongGiamGiaDonHang += $item->giamGia;
            $tongDoanhThu += $item->tongThanhTien;
            $output .= '
            <tr>
            <td class="text-left">
                #' . $item->id . '
            </td>
            <td class="text-left">
                ' . $item->chi_tiet_hoa_dons_sum_so_luong . '
            </td>
            <td class="text-right">
                ' . number_format($item->tongTien, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($item->giamGia, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($item->tongThanhTien, 0, '', ',') . ' ₫
            </td>
        </tr>
        ';
        }
        $output .= '
        <tr>
            <td class="text-left"><strong>Tổng:</strong></td>
            <td class="text-left"><strong>' . $tongSLDonHang . '</strong></td>
            <td class="text-right"><strong>' . number_format($tongDoanhThuDonHang, 0, '', ',') . ' ₫</strong></td>
            <td class="text-right"><strong>' . number_format($tongGiamGiaDonHang, 0, '', ',') . ' ₫</strong></td>
            <td class="text-right"><strong>' . number_format($tongDoanhThu, 0, '', ',') . ' ₫</strong></td>
        </tr>
        ';

        // *** Biểu đồ tròn *** //
        $dataDonHang = [$hoadonDaXuLy, $hoadonDangXuLy, $hoadonDaHuy];
        $dataDoanhThu = [$tongDoanhThuDonHang, $tongGiamGiaDonHang, $tongDoanhThu];
        // *** Biểu đồ tròn *** //



        $lstData = [];
        foreach ($lstDate as $key => $value) {
            $doanhThu = HoaDon::whereDate('created_at', $value)->where('trangThai', 4)->sum('tongTien');
            array_push($lstData, $doanhThu);
            if ($request->type == "thisyear" || $request->type == "lastyear") {
                $lstDate[$key] =
                    $value->format('d/m/Y');
            } else {
                $lstDate[$key] =
                    $value->format('d/m');
            }
        }

        return response()->json([
            'data' => $output,
            'type' => $request->type,
            'success' => "Lấy dữ liệu thành công",
            'labels' => $lstDate,
            'chartData' => $lstData,
            'dataDonHang' => $dataDonHang,
            'dataDoanhThu' => $dataDoanhThu,
            'tongDoanhThu' => number_format($tongDoanhThu, 0, '', ',') . ' ₫',
            'tongSanPham' => $tongSanPham,
            'tongDonHang' => $tongHoaDon,
        ]);
    }

    public function thongKeDoanhThuTheoKhoangThoiGian(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate'
            ],
            [
                'startDate.required' => "Ngày bắt đầu không được bỏ trống",
                'startDate.date' => "Ngày bắt đầu không hợp lệ",
                'endDate.date' => "Ngày bắt đầu không hợp lệ",
                'endDate.required' => "Ngày kết thúc không được bỏ trống",
                'endDate.after_or_equal' => "Ngày kết thúc không được nhỏ hơn ngày bắt đầu",
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

        $data = '';
        $period = "";
        $lstDate = [];

        $tongSanPham = "";
        $tongHoaDon = "";

        $data =
            HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [$request->startDate, $request->endDate])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

        $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [$request->startDate, $request->endDate])->where('trangThai', 4)->count();
        $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [$request->startDate, $request->endDate])->whereIn('trangThai', [0, 1, 2, 3])->count();
        $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [$request->startDate, $request->endDate])->where('trangThai', 5)->count();
        $dataDonHang = [$hoadonDaXuLy, $hoadonDangXuLy, $hoadonDaHuy];

        // *** Thống Kê Số Lượng *** //
        $tongSanPham = DB::table('san_phams')->whereBetween('created_at', [$request->startDate, $request->endDate])->get()->count();
        $tongHoaDon = DB::table('hoa_dons')->whereBetween('created_at', [$request->startDate, $request->endDate])->get()->count();
        // *** Thống Kê Số Lượng *** //

        $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate);

        $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate);

        $type = ($endDate->day - $startDate->day) > 1 ? "" : "today";

        $period = CarbonPeriod::create($request->startDate, $request->endDate);

        foreach ($period as $date) {
            array_push($lstDate, $date);
        }

        $output = "";


        $tongSLDonHang = 0;
        $tongDoanhThuDonHang = 0;
        $tongGiamGiaDonHang = 0;
        $tongDoanhThu = 0;
        foreach ($data as $item) {
            $tongSLDonHang += $item->chi_tiet_hoa_dons_sum_so_luong;
            $tongDoanhThuDonHang += $item->tongTien;
            $tongGiamGiaDonHang += $item->giamGia;
            $tongDoanhThu += $item->tongThanhTien;
            $output .= '
            <tr>
            <td class="text-left">
                #' . $item->id . '
            </td>
            <td class="text-left">
                ' . $item->chi_tiet_hoa_dons_sum_so_luong . '
            </td>
            <td class="text-right">
                ' . number_format($item->tongTien, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($item->giamGia, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($item->tongThanhTien, 0, '', ',') . ' ₫
            </td>
        </tr>
        ';
        }
        $output .= '
        <tr>
            <td class="text-left"><strong>Tổng:</strong></td>
            <td class="text-left"><strong>' . $tongSLDonHang . '</strong></td>
            <td class="text-right"><strong>' . number_format($tongDoanhThuDonHang, 0, '', ',') . ' ₫</strong></td>
            <td class="text-right"><strong>' . number_format($tongGiamGiaDonHang, 0, '', ',') . ' ₫</strong></td>
            <td class="text-right"><strong>' . number_format($tongDoanhThu, 0, '', ',') . ' ₫</strong></td>
        </tr>
        ';

        $dataDoanhThu = [$tongDoanhThuDonHang, $tongGiamGiaDonHang, $tongDoanhThu];

        $lstData = [];
        foreach ($lstDate as $key => $value) {
            $doanhThu = HoaDon::whereDate('created_at', $value)->where('trangThai', 4)->sum('tongTien');
            array_push($lstData, $doanhThu);
            $lstDate[$key] =
                $value->format('d/m');
        }

        return response()->json([
            'data' => $output,
            'type' => $type,
            'success' => "Lấy dữ liệu thành công",
            'labels' => $lstDate,
            'chartData' => $lstData,
            'dataDonHang' => $dataDonHang,
            'dataDoanhThu' => $dataDoanhThu,
            'tongDoanhThu' => number_format($tongDoanhThu, 0, '', ',') . ' ₫',
            'tongSanPham' => $tongSanPham,
            'tongDonHang' => $tongHoaDon,
        ]);
    }

    public function thongKeSoLuong()
    {
        $hoadonDaXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->count();
        $hoadonDangXuLy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->whereIn('trangThai', [0, 1, 2, 3])->count();
        $hoadonDaHuy = DB::table('hoa_dons')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 5)->count();
        $labelsDonHang = ["Đã xử lý", "Đang xử lý", "Đã huỷ"];
        $dataDonHang = [$hoadonDaXuLy, $hoadonDangXuLy, $hoadonDaHuy];

        $doanhThuAfter7Days =
            HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

        $tongDoanhThuTruocGiamGia = 0;
        $tongGiamGia = 0;
        $tongDoanhThuThucTe = 0;
        foreach ($doanhThuAfter7Days as $key => $item) {
            $tongDoanhThuTruocGiamGia += $item->tongTien;
            $tongGiamGia += $item->giamGia;
            $tongDoanhThuThucTe += $item->tongThanhTien;
        }

        $labelsDoanhThu = ["Trước giảm giá", "Giảm giá", "Thực tế"];
        $dataDoanhThu = [$tongDoanhThuTruocGiamGia, $tongGiamGia, $tongDoanhThuThucTe];

        return response()->json([
            'labelsDonHang' => $labelsDonHang,
            'dataDonHang' => $dataDonHang,
            'labelsDoanhThu' => $labelsDoanhThu,
            'dataDoanhThu' => $dataDoanhThu
        ]);
    }
}
