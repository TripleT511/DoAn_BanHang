<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Http\Requests\StoreGioHangRequest;
use App\Http\Requests\UpdateGioHangRequest;
use App\Jobs\SendMail;
use App\Mail\OrderMail;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use App\Models\DanhMuc;
use App\Models\HoaDon;
use App\Models\MaGiamGia;
use App\Models\PhieuKho;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function renderCart()
    {
        $newCart = Session::get('Cart');
        $output = '';
        $total = 0;
        if ($newCart)
            foreach ($newCart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
                $output .= '
                <li>
                    <a href="' . route('chitietsanpham', ['slug' => $item['slug']]) . '">
                        <figure>
                            <img src="' . asset('storage/' . $item['hinhAnh'])  . '" data-src="' . asset('storage/' . $item['hinhAnh'])  . 'g" alt="' . $item['tenSanPham'] . '" width="50" height="50" class="lazy">
                        </figure>
                        <strong>
                            <span>' . $item['soluong'] . 'x ' . $item['tenSanPham'] . '
                            </span>
                            ' . number_format($item['gia'], 0, '', ',') . ' ₫
                        </strong>
                    </a>
                    <a href="#" class="btn-trash action" data-id="' . $item['id'] . '"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', ','),
        ]);
    }
    public function themgiohang(Request $request)
    {
        $lstCart = Session::get('Cart');
        $idSanPham = $request->sanphamId;
        $sanpham = SanPham::whereId($idSanPham)->first();
        $countProductinCart = isset($lstCart[$idSanPham]) ? $lstCart[$idSanPham]['soluong'] : 0;

        $soLuongTon = $sanpham->tonKho - $countProductinCart;

        if ($request->soLuong > $soLuongTon) {
            return response()->json([
                'error' => "Sản phẩm " . $sanpham->tenSanPham . " hiện chỉ còn " . $soLuongTon . " sản phẩm",
            ]);
        }

        if ($lstCart) {
            if (isset($lstCart[$idSanPham])) {
                $lstCart[$idSanPham]['soluong'] = (int)$lstCart[$idSanPham]['soluong'] +  $request->soLuong;
                $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            } else {
                $lstCart[$idSanPham] = array(
                    "id" => $idSanPham,
                    "tenSanPham" => $sanpham->tenSanPham,
                    'slug' => $sanpham->slug,
                    "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                    "sku" => $sanpham->sku,
                    "soluong" => $request->soLuong,
                    "gia" => $sanpham->giaKhuyenMai != 0 ?  $sanpham->giaKhuyenMai : $sanpham->gia,
                    "tongTien" => 0
                );

                $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            }
            Session::put("Cart", $lstCart);
        } else {
            $lstCart[$idSanPham] = array(
                "id" => $idSanPham,
                "tenSanPham" => $sanpham->tenSanPham,
                'slug' => $sanpham->slug,
                "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                "sku" => $sanpham->sku,
                "soluong" => $request->soLuong,
                "gia" => $sanpham->giaKhuyenMai != 0 ?  $sanpham->giaKhuyenMai : $sanpham->gia,
                "tongTien" => 0
            );
            $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            Session::put("Cart", $lstCart);
        }

        $newCart = Session::get('Cart');
        $output = '';
        $total = 0;
        if ($newCart)
            foreach ($newCart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
                $output .= '
                <li>
                    <a href="' . route('chitietsanpham', ['slug' => $item['slug']]) . '">
                        <figure>
                            <img src="' . asset('storage/' . $item['hinhAnh'])  . '" data-src="' . asset('storage/' . $item['hinhAnh'])  . 'g" alt="' . $item['tenSanPham'] . '" width="50" height="50" class="lazy">
                        </figure>
                        <strong>
                            <span>' .  $item['soluong'] . 'x ' . $item['tenSanPham'] . '
                            </span>
                            ' . number_format($item['gia'], 0, '', ',') . ' ₫
                        </strong>
                    </a>
                    <a href="#" class="btn-trash action" data-id="' . $item['id'] . '"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'message' => 'Sản phẩm ' . $sanpham->tenSanPham . ' đã được thêm vào giỏ hàng',
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', ','),

        ]);
    }

    public function capNhatGioHang(Request $request)
    {
        $lstCart = Session::get('Cart');
        $idSanPham = $request->sanphamId;
        $sanpham = SanPham::whereId($idSanPham)->first();

        if ($request->type == "incre") {
            $countProductinCart = isset($lstCart[$idSanPham]) ? $lstCart[$idSanPham]['soluong'] : 0;
            // Số lượng tồn kho
            $soLuongTon = $sanpham->tonKho - $countProductinCart;

            if ($request->soLuong > $soLuongTon) {
                $stringError = "Sản phẩm " . SanPham::find($idSanPham)->tenSanPham . " hiện chỉ còn " . $soLuongTon . " sản phẩm";
                return $this->renderCartTemplate($stringError);
            }
        }

        if ($request->soLuong > 0) {
            if ($request->type == "incre") {
                $lstCart[$idSanPham]['soluong'] += (int)$request->soLuong;
                $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            } else if ($request->type == "decre") {
                $lstCart[$idSanPham]['soluong'] = (int)$lstCart[$idSanPham]['soluong'] - (int)$request->soLuong;
                $lstCart[$idSanPham]['tongTien'] = (int)$lstCart[$idSanPham]['soluong'] *  (float)$lstCart[$idSanPham]['gia'];
            }
        } else {
            unset($lstCart[$idSanPham]);
        }
        Session::put("Cart", $lstCart);
        return $this->renderCartTemplate();
    }

    public function renderCartTemplate($error = '')
    {

        $newCart = Session::get('Cart');
        $discountCode = Session::get('DiscountCode');
        $output = '';
        $outputMain = '';
        $total = 0;
        if ($newCart) {
            foreach ($newCart as $item) {
                $item['tongTien'] = (float)$item['gia'] * (int)$item['soluong'];
                $total += (float)$item['gia'] * (int)$item['soluong'];
                $output .= '
                <li>
                    <a href="' . route('chitietsanpham', ['slug' => $item['slug']]) . '">
                        <figure>
                            <img src="' . asset('storage/' . $item['hinhAnh'])  . '" data-src="' . asset('storage/' . $item['hinhAnh'])  . 'g" alt="' . $item['tenSanPham'] . '" width="50" height="50" class="lazy">
                        </figure>
                        <strong>
                            <span>' . $item['soluong'] . 'x ' . $item['tenSanPham'] . '
                            </span>
                            ' . $item['gia'] . ' ₫
                        </strong>
                    </a>
                    <a href="#"  class="btn-trash action" data-id="' . $item['id'] . '"><i class="ti-trash"></i></a>
                </li>
                ';
                $outputMain .= '
                    <tr>
                        <td>
                            <div class="thumb_cart">
                                <img src="' . asset('storage/' . $item['hinhAnh']) . '" data-src="' . asset('storage/' . $item['hinhAnh']) . '" class="lazy" alt="Image">
                            </div>
                            <span class="item_cart">' . $item['tenSanPham']  . '</span>
                        </td>
                        <td>
                            <strong>' . number_format($item['gia'], 0, '', ',')  . ' ₫</strong>
                        </td>
                        <td>
                            <div class="numbers-row">
                                <input type="text" value=" ' . $item['soluong'] . ' " id="quantity_1" class="qty2" name="quantity_1">
                            <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                        </td>
                        <td>
                            <strong>' . number_format($item['tongTien'], 0, '', ',') . '  ₫</strong>
                        </td>
                        <td class="options">
                            <a href="#" class="btn-trash" data-id="' . $item['id'] . '"><i class="ti-trash"></i></a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $outputMain .= '
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-12">
                            <div class="cart-empty">
                                <div class="img">
                                    <img src="' . asset('img/cart-empty.png') . '" alt="Giỏ hàng trống">
                                </div>
                                <h3 class="text-center">
                                    <strong>Bạn chưa có sản phẩm nào trong giỏ hàng</strong>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
         ';
        }
        $valueDiscount = 0;
        $newTotal = $total;
        if ($discountCode) {
            $loaiKhuyenMai = $discountCode['type'];
            $value =  $discountCode['value'];
            $maxValue = $discountCode['max_value'];

            if ($loaiKhuyenMai == 0) {
                $newTotal = $total - $value;
                $valueDiscount = $total - $newTotal;
                if ($maxValue && $valueDiscount > $maxValue) {
                    $newTotal = $total - $maxValue;
                    $valueDiscount = $total - $newTotal;
                }
            } else if ($loaiKhuyenMai == 1) {
                $percent = $value / 100;
                $newTotal = $total - ($total * $percent);
                $valueDiscount = $total - $newTotal;
                if ($maxValue && $valueDiscount > $maxValue) {
                    $newTotal = $total - $maxValue;
                    $valueDiscount = $total - $newTotal;
                }
            }
        }


        return response()->json([
            'cartMain' => $outputMain,
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', ','),
            'discount' =>
            number_format($valueDiscount, 0, '', ','),
            'success' => $valueDiscount != 0 ? 'Áp dụng mã giảm giá thành công' : 'Cập nhật giỏ hàng thành công',
            'newTotal' =>
            number_format($newTotal, 0, '', ','),
            'error' => $error
        ]);
    }

    public function xoaGioHang(Request $request)
    {
        $idSanPham = $request->sanphamId;
        $lstCart = Session::get('Cart');
        if ($lstCart) {
            if (isset($lstCart[$idSanPham])) {
                unset($lstCart[$idSanPham]);
            }
            Session::put("Cart", $lstCart);
        }

        Session::forget('DiscountCode');

        return $this->renderCartTemplate();
    }


    public function index(Request $request)
    {
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();

        Session::forget("DiscountCode");
        $Cart = Session::get('Cart');
        $countCart = $Cart ? count($Cart) : 0;
        $total = 0;
        $lstDiscount = MaGiamGia::where('ngayKetThuc', '>=', date('Y-m-d H:i:s'))->where('ngayBatDau', '<=', date('Y-m-d H:i:s'))->where('soLuong', '>', 0)->orWhereNull('soLuong')->get();

        if ($Cart)
            foreach ($Cart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
            }

        return view('cart', [
            'Cart' => $Cart ? $Cart : [],
            'countCart' => $countCart,
            'total' => $total,
            'lstDiscount' => $lstDiscount,
            'lstDanhMuc' => $lstDanhMuc,
            'lstDanhMucHeader' => $lstDanhMucHeader
        ]);
    }

    public function viewCheckOut(Request $request)
    {
        if (Auth::check() && Auth::user()->phan_quyen_id == 2) {
            $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
            $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
            $Cart = Session::get('Cart');
            if (!$Cart) {
                return Redirect::back();
            }
            $discountCode = Session::get('DiscountCode');
            $countCart = $Cart ? count($Cart) : 0;
            $total = 0;

            if ($Cart)
                foreach ($Cart as $item) {
                    $total += (float)$item['gia'] * (int)$item['soluong'];
                }
            $newTotal = $total;
            $valueDiscount = 0;
            if ($discountCode) {
                $loaiKhuyenMai = $discountCode['type'];
                $value =  $discountCode['value'];
                $maxValue = $discountCode['max_value'];
                if ($loaiKhuyenMai == 0) {
                    $newTotal = $total - $value;
                    $valueDiscount = $total - $newTotal;
                    if ($maxValue && $valueDiscount > $maxValue) {
                        $newTotal = $total - $maxValue;
                        $valueDiscount = $total - $newTotal;
                    }
                } else if ($loaiKhuyenMai == 1) {
                    $percent = $value / 100;
                    $newTotal = $total - ($total * $percent);
                    $valueDiscount = $total - $newTotal;
                    if ($maxValue && $valueDiscount > $maxValue) {
                        $newTotal = $total - $maxValue;
                        $valueDiscount = $total - $newTotal;
                    }
                }
            }
            return view('checkout', [
                'user' => Auth::user(),
                'Cart' => $Cart ? $Cart : [],
                'countCart' => $countCart,
                'total' => $total,
                'newTotal' => $newTotal,
                'discount' =>
                number_format($valueDiscount != 0 ? -$valueDiscount : $valueDiscount, 0, '', ','),
                'lstDanhMuc' => $lstDanhMuc,
                'lstDanhMucHeader' => $lstDanhMucHeader
            ]);
        }

        return redirect()->route('user.login')->withErrors('Bạn cần đăng nhập để tiếp tục');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'hoTen_billing' => 'required',
            'email_billing' => 'required|email',
            'diaChi_billing' => 'required',
            'soDienThoai_billing' => 'required',
        ], [
            'hoTen_billing.required' => 'Họ tên không được để trống',
            'email_billing.required' => 'Email không được để trống',
            'email_billing.email' => 'Email không hợp lệ',
            'diaChi_billing.required' => 'Địa chỉ không được bỏ trống',
            'soDienThoai_billing.required' => 'Số điện thoại không được để trống',
        ]);

        $Cart = Session::get('Cart');
        if (!$Cart) {
            return redirect()->route('gio-hang');
        }

        DB::beginTransaction();

        try {
            $discountCode = Session::get('DiscountCode');
            $user = Auth::user();
            $total = 0;


            $hoadon = new HoaDon();
            $hoadon->fill([
                'nhan_vien_id' => null,
                'khach_hang_id' => $user->id,
                'hoTen' => $request->hoTen_billing,
                'email' => $request->email_billing,
                'diaChi' => $request->diaChi_billing,
                'soDienThoai' => $request->soDienThoai_billing,
                'ngayXuatHD' => date('Y-m-d H:i:s'),
                'tongTien' => 0,
                'ghiChu' => $request->ghiChu_billing,
                'trangThai' => 0,
            ]);
            $hoadon->save();

            $newArray = [];

            foreach ($Cart as $item) {
                array_push($newArray, [
                    'tenSanPham' => $item['tenSanPham'],
                    'soLuong' => $item['soluong'],
                    'donGia' => $item['gia'],
                    'tongTien' => $item['gia'] * $item['soluong'],
                ]);

                // Sản phẩm
                $sanpham = SanPham::whereId($item['id'])->where('tonKho', '>', 0)->first();
                $sanpham->tonKho = $sanpham->tonKho - $item['soluong'];
                $sanpham->save();
                // Thêm chi tiết hoá đơn
                $chiTietHoaDon = new ChiTietHoaDon();
                $chiTietHoaDon->fill([
                    'hoa_don_id' => $hoadon->id,
                    'san_pham_id' => $item['id'],
                    'soLuong' => $item['soluong'],
                    'donGia' => $item['gia'],
                    'tongTien' => $item['gia'] * $item['soluong'],
                ]);
                $chiTietHoaDon->save();

                // Thêm giỏ hàng
                $gioHang = new GioHang();
                $gioHang->fill([
                    'san_pham_id' => $item['id'],
                    'user_id' => $user->id,
                    'soLuong' => $item['soluong'],
                ]);
                $gioHang->save();



                $total += (int)$item['soluong'] * (float)$item['gia'];
            }

            $hoadon->tongTien = $total;
            $hoadon->giamGia = 0;
            $hoadon->tongThanhTien = $total;
            $hoadon->save();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            $lstSanPhamHetHang = "";
            foreach ($Cart as $item) {
                $sanpham = SanPham::whereId($item['id'])->first();
                if ($sanpham->tonKho = 0) {
                    $lstSanPhamHetHang .= $sanpham->tenSanPham;
                }
            }
            return
                back()->withErrors([
                    'error' => 'Đã xảy ra lỗi. Chúng tôi thành thật xin lỗi vì điều này !',
                    'lstSanPhamHetHang' => $lstSanPhamHetHang . "đã hết hàng",
                ]);
        }


        $valueDiscount = 0;
        $infoPayMent = array(
            "thanhTien" => number_format($total, 0, '', ',') . " đ",
            "vanChuyen" => number_format(0, 0, '', ',') . " đ",
            "giamGia" => number_format(0, 0, '', ',') . " đ",
            "tongCong" => number_format(0, 0, '', ',') . " đ",
            "hinhThuc" => "Thanh toán khi nhận hàng"
        );
        if ($discountCode) {
            $loaiKhuyenMai = $discountCode['type'];
            $value =  $discountCode['value'];
            $maxValue = $discountCode['max_value'];
            $newTotal = 0;
            if ($loaiKhuyenMai == 0) {
                $newTotal = $total - $value;
                $valueDiscount = $total - $newTotal;
                if ($maxValue && $valueDiscount > $maxValue) {
                    $newTotal = $total - $maxValue;
                    $valueDiscount = $total - $newTotal;
                }
                $total = $newTotal;
            } else if ($loaiKhuyenMai == 1) {
                $percent = $value / 100;
                $newTotal = $total - ($total * $percent);
                $valueDiscount = $total - $newTotal;
                if ($maxValue && $valueDiscount > $maxValue) {
                    $newTotal = $total - $maxValue;
                    $valueDiscount = $total - $newTotal;
                }
                $total = $newTotal;
            }
        }

        $hoadon->giamGia = $valueDiscount;
        $hoadon->tongThanhTien = $total;
        $hoadon->save();

        $infoPayMent["giamGia"] = number_format($valueDiscount, 0, '', ',') . " đ";
        $infoPayMent["tongCong"] = number_format($total, 0, '', ',') . " đ";

        $this->dispatch(new SendMail($user, $hoadon, $newArray, $infoPayMent));

        Session::put("Cart", []);
        // Trừ số lượng mã
        if ($discountCode) {
            $maGiamGia = MaGiamGia::whereId($discountCode["id"])->first();
            if ($maGiamGia->soLuong != null) {

                $maGiamGia->soLuong = $maGiamGia->soLuong - 1;
                $maGiamGia->save();
            }
        }
        Session::forget("DiscountCode");
        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id')->take(1)->get();
        return view('confirm-checkout', ['lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }

    public function addDiscountCode(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'required|exists:ma_giam_gias,code',
            ],
            [
                'code.required' => "Mã giảm giá không được bỏ trống",
                'code.exists' => "Mã giảm giá không tồn tại"
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

        $code = MaGiamGia::where('code', $request->code)->first();
        $currentDate = date('Y-m-d H:i:s');
        if ($code->ngayBatDau > $currentDate) {
            return response()->json([
                'error' => 'Mã giảm giá chưa đến thời gian khuyến mãi',
                'current-date' => $currentDate,
                'start' => $code->ngayBatDau,
                'end' => $code->ngayKetThuc
            ]);
        } else if (date('Y-m-d', strtotime($code->ngayKetThuc . " +1 days")) < $currentDate) {
            return response()->json([
                'error' => 'Mã giảm giá đã hết hạn, vui lòng sử dụng mã khác',
                'current-date' => $currentDate,
                'start' => $code->ngayBatDau,
                'end' => $code->ngayKetThuc
            ]);
        }

        if ($code->soLuong <= 0 && $code->soLuong != null && $code->soLuong) {
            return response()->json(['error' => 'Lượt sử dụng mã đã hết, vui lòng sử dụng mã khác']);
        }

        if ($code->giaTriToiThieu != null && $request->total < $code->giaTriToiThieu) {
            return response()->json(['error' => 'Đơn hàng chưa đủ điều kiện để sử dụng mã này']);
        }

        Session::forget("DiscountCode");
        $discountCode = array(
            'id' => $code->id,
            'code' => $code->code,
            'type' => $code->loaiKhuyenMai,
            'value' => $code->giaTriKhuyenMai,
            'max_value' => $code->mucGiamToiDa,
        );
        Session::put("DiscountCode", $discountCode);

        return $this->renderCartTemplate();
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
     * @param  \App\Http\Requests\StoreGioHangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGioHangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function show(GioHang $gioHang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function edit(GioHang $gioHang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGioHangRequest  $request
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGioHangRequest $request, GioHang $gioHang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GioHang  $gioHang
     * @return \Illuminate\Http\Response
     */
    public function destroy(GioHang $gioHang)
    {
        //
    }
}
