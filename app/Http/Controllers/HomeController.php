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
use App\Jobs\SendMail3;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
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

        $lstSanPhamNoiBat = SanPham::where('dacTrung', 2)->with('hinhanhs')->with('danhmuc')->with('danhgias')->orderBy('created_at', 'desc')->get();

        $lstSanPhamBanChay = SanPham::where('dacTrung', 1)->with('hinhanhs')->with('danhmuc')->with('danhgias')->orderBy('created_at', 'desc')->take(8)->get();

        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'asc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();

        return view('home', [
            'lstSanPham' => $lstSanPham, 'lstSanPhamNoiBat' => $lstSanPhamNoiBat,
            'lstSanPhamBanChay' => $lstSanPhamBanChay, 'lstSlider' => $lstSlider, 'lstDanhMuc' => $lstDanhMuc,
            'lstDanhMucHeader' => $lstDanhMucHeader
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sanpham($slug)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();

        $sanpham = SanPham::with('hinhanhs')->with('danhmuc')->with('color')->with('sizes')->withCount('soluongthuoctinh')->where('slug', $slug)->orWhere('id', $slug)->first();

        // return $sanpham;

        $lstDanhGia = DanhGia::with('sanpham')->with('taikhoan')->where('san_pham_id', $sanpham->id)->orderBy('created_at', 'desc')->get();
        $starActive = floor($lstDanhGia->avg('xepHang'));
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

        return view('product-detail', ['sanpham' => $sanpham, 'lstDanhGia' => $lstDanhGia, 'lstDanhMuc' => $lstDanhMuc, 'lstSanPhamLienQuan' => $lstSanPhamLienQuan, 'countRating' => $countRating, 'starActive' => $starActive, 'starNonActive' => $starNonActive, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }

    public function danhmucsanpham($slug, Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        //
        $danhmucCha = DanhMuc::where('slug', $slug)->first();
        $lstDanhMucCon = DanhMuc::where('idDanhMucCha', $danhmucCha->id)->with('childs')->get();
        $lstIdDanhMucCon = [$danhmucCha->id];


        foreach ($lstDanhMucCon as $danhmuc) {
            array_push($lstIdDanhMucCon, $danhmuc->id);
        }

        if ($danhmucCha->id == 1) {
            $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias');
        } else {
            $lstSanPham = SanPham::whereIn('danh_muc_id', $lstIdDanhMucCon)->with('hinhanhs')->with('danhmuc')->with('danhgias');
        }

        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'rating':
                    $lstSanPham = $lstSanPham->withAvg('danhgias', 'xepHang')->orderBy('danhgias_avg_xep_hang', 'desc');
                    break;
                case 'date':
                    $lstSanPham = $lstSanPham->orderBy('created_at', 'desc');
                    break;
                case 'price':
                    $lstSanPham = $lstSanPham->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end'
                    );
                    break;
                case 'pricedesc':
                    $lstSanPham = $lstSanPham->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end DESC'
                    );
                    break;
                default:
                    $lstSanPham = $lstSanPham;
                    break;
            }
        }

        if ($request->has('danhmuc') && !empty($request->danhmuc)) {
            $danhmucCha = DanhMuc::whereId($request->danhmuc)->first();
            $lstDanhMucCon = DanhMuc::where('idDanhMucCha', $danhmucCha->id)->get();
            $lstIdDanhMucCon = [$danhmucCha->id];
            foreach ($lstDanhMucCon as $danhmuc)
                array_push($lstIdDanhMucCon, $danhmuc->id);
            $lstSanPham = $lstSanPham->whereIn('danh_muc_id', $lstIdDanhMucCon);
        }

        if ($request->has('price') && !empty($request->price)) {
            switch ($request->price) {
                case 'duoi3':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<', 300000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '<', 300000);
                        });
                    });
                    break;
                case '3den5':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>=', 300000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>=', 300000);
                        })->where(function ($query) {
                            $query->where(function ($query) {
                                $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<=', 500000);
                            })->orWhere(function ($query) {
                                $query->where('gia', '<=', 500000);
                            });
                        });
                    });
                    break;
                case '1mden3m':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>=', 1000000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>=', 1000000);
                        })->where(function ($query) {
                            $query->where(function ($query) {
                                $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<=', 3000000);
                            })->orWhere(function ($query) {
                                $query->where('gia', '<=', 3000000);
                            });
                        });
                    });
                    break;
                case 'tren3m':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>', 3000000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>', 3000000);
                        });
                    });
                    break;
                default:
                    $lstSanPham = $lstSanPham;
                    break;
            }
        }

        return view('danh-muc', ['lstSanPham' => $lstSanPham->paginate(8), 'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader, 'slug' => $slug, 'page' => $request->page, 'sort' => $request->sort, 'danhmuc' => $request->danhmuc, 'price' => $request->price]);
    }

    public function lstSanPham(Request $request)
    {
        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias');

        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'rating':
                    $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias')->withAvg('danhgias', 'xepHang')->orderBy('danhgias_avg_xep_hang', 'desc');
                    break;
                case 'date':
                    $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias')->orderBy('created_at', 'desc');
                    break;
                case 'price':
                    $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias')->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end'
                    );
                    break;
                case 'pricedesc':
                    $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias')->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end DESC'
                    );
                    break;
                default:
                    $lstSanPham = $lstSanPham;
                    break;
            }
        }

        if ($request->has('danhmuc') && !empty($request->danhmuc)) {
            $danhmucCha = DanhMuc::whereId($request->danhmuc)->first();
            $lstDanhMucCon = DanhMuc::where('idDanhMucCha', $danhmucCha->id)->get();
            $lstIdDanhMucCon = [$danhmucCha->id];
            foreach ($lstDanhMucCon as $danhmuc)
                array_push($lstIdDanhMucCon, $danhmuc->id);
            $lstSanPham = $lstSanPham->whereIn('danh_muc_id', $lstIdDanhMucCon);
        }

        if ($request->has('price') && !empty($request->price)) {
            switch ($request->price) {
                case 'duoi3':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<', 300000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '<', 300000);
                        });
                    });
                    break;
                case '3den5':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>=', 300000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>=', 300000);
                        })->where(function ($query) {
                            $query->where(function ($query) {
                                $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<=', 500000);
                            })->orWhere(function ($query) {
                                $query->where('gia', '<=', 500000);
                            });
                        });
                    });
                    break;
                case '1mden3m':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>=', 1000000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>=', 1000000);
                        })->where(function ($query) {
                            $query->where(function ($query) {
                                $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '<=', 3000000);
                            })->orWhere(function ($query) {
                                $query->where('gia', '<=', 3000000);
                            });
                        });
                    });
                    break;
                case 'tren3m':
                    $lstSanPham = $lstSanPham->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where('giaKhuyenMai', '>', 0)->where('giaKhuyenMai', '>', 3000000);
                        })->orWhere(function ($query) {
                            $query->where('gia', '>', 3000000);
                        });
                    });
                    break;
                default:
                    $lstSanPham = $lstSanPham;
                    break;
            }
        }


        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        return view('san-pham', ['lstSanPham' => $lstSanPham->paginate(8), 'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader, 'page' => $request->page, 'sort' => $request->sort, 'danhmuc' => $request->danhmuc, 'price' => $request->price]);
    }


    public function searchSP(Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();

        $stringSearch = $request->keyword;


        $lstSanPham = SanPham::with('hinhanhs')->with('danhmuc')->with('danhgias');


        if (!empty($stringSearch)) {
            $lstSanPham = $lstSanPham->whereHas('danhmuc', function ($query) use ($stringSearch) {
                $query->where('tenDanhMuc', 'LIKE', '%' . $stringSearch . '%');
            })->orWhere('tenSanPham', 'LIKE', '%' . $stringSearch . '%')->orWhere('sku', 'LIKE', '%' . $stringSearch . '%');
        }

        // Sort
        if ($request->has('sort') && !empty($request->sort)) {
            switch ($request->sort) {
                case 'rating':
                    $lstSanPham = $lstSanPham->withAvg('danhgias', 'xepHang')->orderBy('danhgias_avg_xep_hang', 'desc');
                    break;
                case 'date':
                    $lstSanPham = $lstSanPham->orderBy('created_at', 'desc');
                    break;
                case 'price':
                    $lstSanPham = $lstSanPham->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end'
                    );
                    break;
                case 'pricedesc':
                    $lstSanPham = $lstSanPham->orderByRaw(
                        'case
                        when `giaKhuyenMai` > 0 then `giaKhuyenMai`
                        else `gia`
                        end DESC'
                    );
                    break;
                default:
                    $lstSanPham = $lstSanPham;
                    break;
            }
        }

        // Sort
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
        return view('search', ['lstSanPham' => $lstSanPham->paginate(8), 'keyword' => $request->keyword, 'soluong' => $soluong,  'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader, 'page' => $request->page, 'sort' => $request->sort]);
    }

    public function myOrder()
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucNew = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(3)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        $lstDonHang = HoaDon::where('khach_hang_id', Auth()->user()->id)->with('chiTietHoaDons')->with(['chiTietHoaDons.sanpham' => function ($query) {
            $query->with('hinhanhs');
        }])->orderBy('created_at', 'desc')->get();


        return view('my-order', ['lstDanhMuc' => $lstDanhMuc, 'lstDonHang' => $lstDonHang, 'lstDanhMucHeader' => $lstDanhMucHeader, 'lstDanhMucNew' => $lstDanhMucNew]);
    }

    public function myOrderDetail(Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        $hoadon = HoaDon::whereId($request->id)->with('user')->with('khachhang')->with('chiTietHoaDons')->with('chiTietHoaDons.sanpham')->first();
        if (!$hoadon) {
            return back()->with('message', 'Đã xảy ra lỗi');
        }

        return view('order-detail', ['hoadon' => $hoadon, 'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }

    public function huyDatHang(Request $request)
    {
        $hoadon = HoaDon::whereId($request->hoadon)->first();
        $hoadon->trangThai = 5;
        $hoadon->save();
        $this->dispatch(new SendMail3($hoadon));
        return Redirect::route('myOrder');
    }

    public function nhanHangThanhCong(Request $request)
    {
        $hoadon = HoaDon::whereId($request->hoadon)->first();
        $hoadon->trangThaiThanhToan = 1;
        $hoadon->trangThai = 4;
        $hoadon->save();
        return Redirect::route('myOrder');
    }

    public function locDonHang(Request $request)
    {
        $lstDonHang = HoaDon::where('khach_hang_id', Auth()->user()->id)->with('chiTietHoaDons')->with(['chiTietHoaDons.sanpham' => function ($query) {
            $query->with('hinhanhs');
        }])->orderBy('created_at', 'desc');

        $output = "";

        switch ($request->type) {
            case "waiting":
                $lstDonHang = $lstDonHang->where('trangThai', 0)->orderBy('created_at', 'desc')->get();
                break;
            case "processed":
                $lstDonHang = $lstDonHang->where('trangThai', 1)->orderBy('created_at', 'desc')->get();
                break;
            case "packing":
                $lstDonHang = $lstDonHang->where('trangThai', 2)->orderBy('created_at', 'desc')->get();
                break;
            case "shipping":
                $lstDonHang = $lstDonHang->where('trangThai', 3)->orderBy('created_at', 'desc')->get();
                break;
            case "done":
                $lstDonHang = $lstDonHang->where('trangThai', 4)->orderBy('created_at', 'desc')->get();
                break;
            case "cancel":
                $lstDonHang = $lstDonHang->where('trangThai', 5)->orderBy('created_at', 'desc')->get();
                break;
            default:
                $lstDonHang = $lstDonHang->orderBy('created_at', 'desc')->get();
                break;
        }

        foreach ($lstDonHang as $item) {
            $trangThai = "";
            $hanhDong = "";

            switch ($item->trangThai) {
                case 0:
                    $trangThai = '<span class="badge bg-label-primary">Chờ xử lý</span>';
                    $hanhDong = '
                        <form action="' . route('huyDatHang', ['hoadon' => $item]) . '" method="post">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button type="submit"  class="btn btn-danger">Huỷ đơn hàng</button>
                        </form>
                    ';
                    break;
                case 1:
                    $trangThai = '<span class="badge bg-label-success">Đã xử lý</span>';
                    $hanhDong = '
                        <form action="' . route('huyDatHang', ['hoadon' => $item]) . '" method="post">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button type="submit"  class="btn btn-danger">Huỷ đơn hàng</button>
                        </form>
                    ';
                    break;
                case 2:
                    $trangThai = '<span class="badge bg-label-info">Đang đóng gói</span>';
                    break;
                case 3:
                    $trangThai = '<span class="badge bg-label-warning">Đang giao hàng</span>';
                    $hanhDong = '<a href="#" class="btn btn-success">Đã nhận hàng</a>';
                    break;
                case 4:
                    $trangThai = '<span class="badge bg-label-success">Đã giao</span>';
                    break;
                case 5:
                    $trangThai = '<span class="badge bg-label-danger">Đã huỷ</span>';
                    break;
                default:
                    $trangThai = '<span class="badge bg-label-dark">Không xác định</span>';
                    break;
            }

            $chitiethoadon = "";

            foreach ($item->chiTietHoaDons as $cthd) {
                $chitiethoadon .= '
                    <li>
                        <a href="' . route('chitietsanpham', ['slug' => $cthd->sanpham->slug]) . '">
                            <div class="title">
                                <h5>' . $cthd->sanpham->tenSanPham . ' x ' .  $cthd->soLuong . '</h5>
                                <span>' . number_format($cthd->donGia, 0, '', '.')  . ' ₫</span>
                            </div>
                        </a>
                    </li>
                ';
            }


            $output .= '
                <tr>
                        <td>
                        <a href="' . route('myOrderDetail', ['id' => $item->id]) . '">
								#' . $item->id . '
							</a>
                        </td>
						<td>
							<ul class="lst-product">
								' . $chitiethoadon . '
							</ul>
						</td>
						<td>
							<strong>' . number_format($item->tongThanhTien, 0, '', '.')  . ' ₫</strong>
						</td>
						<td>
							' . $trangThai . '
						</td>
						<td>
							' . $hanhDong . '
						</td>
						
					</tr>
            ';
        }


        return response()->json([
            'data' => $output
        ]);
    }


    public function slider($slug)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();

        $slider = Slider::where('slug', $slug)->first();

        return view('slider', ['slider' => $slider, 'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }

    public function formResetPassWord(Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        return view('user.reset-password', ['token' => $request->token, 'lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
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
            return  redirect()->back()->withErrors("error", "Token đã hết hạn");
        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->update();
        $passwordReset = DB::table('password_resets')->where('token', $request->token)->delete();

        return redirect()->route('user.login')->with('message', 'Vui lòng đăng nhập');
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'soDienThoai' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống',
            'password.min' => 'Mật khẩu tối thiểu 6 kí tự',
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'soDienThoai.min' => 'Số điện thoại không hợp lệ',
            'g-recaptcha-response.required' => 'Vui lòng xác nhận captcha',
        ]);

        if ($request->filled('soDienThoai')) {
            $request->validate([
                'soDienThoai' => 'regex:/((09|03|07|08|05)+([0-9]{8,9})\b)/'
            ], [
                'soDienThoai.regex' => 'Số điện thoại không hợp lệ'
            ]);
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'password.regex' => 'Mật khẩu tối thiểu 6 kí tự, bao gồm số, chữ hoa và chữ thường'
            ]);
        }



        $user = new User();
        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'soDienThoai' => $request->input('soDienThoai'),
            'phan_quyen_id' => '2',
            'anhDaiDien' => 'images/user-default.jpg',
            'diaChi' => ''
        ]);
        $user->save();

        $hash = Str::random(30);

        $this->dispatch(new SendMail2($user, $hash, $request->email));

        return Redirect::route('user.login')->with('message', 'Vui lòng kiểm tra email để xác nhận tài khoản');
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
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        return view('user', ['lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }

    public function changePass()
    {
        if (Auth()->user()->social_type != null) {
            return Redirect::back();
        }
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', 1)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        return view('change-password', ['lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
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

        if ($request->filled('newpassword')) {
            $request->validate([
                'newpassword' => 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]).{6,}$/'
            ], [
                'newpassword.regex' => 'Mật khẩu tối thiểu 6 kí tự, bao gồm số, chữ hoa và chữ thường'
            ]);
        }

        $user = User::whereId($request->user)->first();

        if (!Hash::check($request->password, $user->password)) {
            return Redirect::back()->withErrors(['password' => 'Mật khẩu cũ không đúng, vui lòng nhập lại']);
        }

        $user->fill([
            'password' => Hash::make($request->newpassword),
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
            'hoTen.max' => "Họ tên tối đa 255 kí tự",
            'soDienThoai.required' => 'Số điện thoại không được bỏ trống',
            'diaChi.required' => 'Địa Chỉ không được bỏ trống',
        ]);

        if ($request->filled('soDienThoai')) {
            $request->validate([
                'soDienThoai' => 'regex:/((09|03|07|08|05)+([0-9]{8,9})\b)/'
            ], [
                'soDienThoai.regex' => 'Số điện thoại không hợp lệ'
            ]);
        }


        $user = User::whereId($request->user)->first();

        $user->fill([
            'hoTen' => $request->input('hoTen'),
            'email' => $user->email,
            'password' => $user->password,
            'anhDaiDien' => $user->anhDaiDien,
            'diaChi' => $request->input('diaChi'),
            'soDienThoai' => $request->input('soDienThoai'),
        ]);
        $user->save();

        if ($request->hasFile('anhDaiDien')) {
            if ($user->anhDaiDien != 'images/user-default.jpg') {
                Storage::disk('public')->delete($user->anhDaiDien);
            }
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
