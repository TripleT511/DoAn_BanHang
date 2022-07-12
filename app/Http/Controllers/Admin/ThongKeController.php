<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BaoCaoThongKeExport;
use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use App\Models\LuotTimKiem;
use App\Models\SanPham;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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


        return View('admin.thongke', [
            'doanhThuAfter7Days' => $doanhThu,
            'top5SanPhamBanChay' => $top5SanPhamBanChay,
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

        switch ($request->type) {
            case 'today':
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                break;
            case 'yesterday':
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now()->subDays(1))->where('trangThai', 4)->orderBy('created_at', 'desc')->get();

                break;
            case 'last7days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(6)->toDateString(), Carbon::now()->toDateString());

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }

                break;
            case 'last30days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(29)->toDateString(), Carbon::now()->toDateString());

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'last90days':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subDays(89)->toDateString(), Carbon::now()->toDateString());

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            case 'lastmonth':
                $data =
                    HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereBetween('created_at', [Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth()])->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                $period = CarbonPeriod::create(Carbon::now()->subMonth(1)->startOfMonth(), Carbon::now()->subMonth(1)->endOfMonth());

                foreach ($period as $date) {
                    array_push($lstDate, $date);
                }
                break;
            default:
                $data = HoaDon::with('chiTietHoaDons')->withSum('chiTietHoaDons', 'soLuong')->whereDate('created_at', Carbon::now())->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                break;
        }


        $output = "";


        $tongSLDonHang = 0;
        $tongDoanhThuDonHang = 0;
        $tongGiamGiaDonHang = 0;
        $tongDoanhThu = 0;
        foreach ($data as $item) {

            $giamGia = 0;
            $doanhThu = $item->tongTien;
            if ($item->ma_giam_gia_id != null) {
                $doanhThu = 0;
                foreach ($item->chiTietHoaDons as $item2) {
                    $doanhThu += $item2->soLuong * $item2->donGia;
                }

                $giamGia = $doanhThu - $item->tongTien;
            }

            $tongSLDonHang += $item->chi_tiet_hoa_dons_sum_so_luong;
            $tongDoanhThuDonHang += $doanhThu;
            $tongGiamGiaDonHang += $giamGia;
            $tongDoanhThu += $item->tongTien;
            $output .= '
            <tr>
            <td class="text-left">
                #' . $item->id . '
            </td>
            <td class="text-left">
                ' . $item->chi_tiet_hoa_dons_sum_so_luong . '
            </td>
            <td class="text-right">
                ' . number_format($doanhThu, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($giamGia, 0, '', ',') . ' ₫
            </td>
            <td class="text-right">
                ' . number_format($item->tongTien, 0, '', ',') . ' ₫
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

        $lstData = [];
        foreach ($lstDate as $key => $value) {
            $doanhThu = HoaDon::whereDate('created_at', $value)->where('trangThai', 4)->sum('tongTien');
            array_push($lstData, $doanhThu);
            $lstDate[$key] =
                $value->format('d/m');
        }

        return response()->json([
            'data' => $output,
            'type' => $request->type,
            'success' => "Lấy dữ liệu thành công",
            'labels' => $lstDate,
            'chartData' => $lstData
        ]);
    }

    public function thongKeSoLuong()
    {
        $hoadonDaXuLy = DB::table('hoa_dons')->where('trangThai', 4);
        $hoadonDangXuLy = DB::table('hoa_dons')->whereIn('trangThai', [0, 1, 2, 3]);
        $hoadonDangHuy = DB::table('hoa_dons')->where('trangThai', 5);
    }

    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel= $excel;
    }

    public function ExportBaoCao()
    {
        return $this->excel->download(new BaoCaoThongKeExport , 'baocao.xlsx');
        
        // return Excel::download($export , 'users.xlsx');
    }
   
    
}
