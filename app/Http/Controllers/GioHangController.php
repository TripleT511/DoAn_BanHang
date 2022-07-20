<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Http\Requests\StoreGioHangRequest;
use App\Http\Requests\UpdateGioHangRequest;
use App\Jobs\SendMail;
use App\Mail\OrderMail;
use App\Models\BienTheSanPham;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use App\Models\DanhMuc;
use App\Models\HoaDon;
use App\Models\MaGiamGia;
use App\Models\PhieuKho;
use App\Models\SanPham;
use App\Models\TuyChonBienThe;
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
                            ' . number_format($item['gia'], 0, '', '.')  . ' ₫
                        </strong>
                    </a>
                    <a href="#" class="btn-trash action" data-id="' . $item['sku'] . '"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', '.'),
        ]);
    }
    public function themgiohang(Request $request)
    {
        $lstCart = Session::get('Cart');
        $idSanPham = $request->sanphamId;
        $countProductinCart = 0;
        $soLuongTon = 0;
        $sanpham = SanPham::whereId($idSanPham)->with('color')->with('sizes')->withCount('soluongthuoctinh')->first();
        $BienTheSizeExist = '';
        $tuyChonBienThe = '';

        $stringTenSanPham = $sanpham->tenSanPham . " - " . $sanpham->color->tuychonbienthe->color->tieuDe;
        if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {
            if (!$request->has('size') || empty($request->size)) {
                return response()->json([
                    'error' => "Cần chọn size cho sản phẩm này",
                ]);
            }

            $BienTheSizeExist = BienTheSanPham::where([
                'san_pham_id' => $sanpham->id,
                'id' => $request->size
            ])->with('tuychonbienthe')->first();

            $tuyChonBienThe = TuyChonBienThe::where('bien_the_san_pham_id', $BienTheSizeExist->id)->with('thuoctinh')->first();

            if (!$BienTheSizeExist) {
                return response()->json([
                    'error' => "Size sản phẩm không tồn tại hoặc đã bị xoá khỏi hệ thống",
                ]);
            }

            $stringTenSanPham .= " - " . $tuyChonBienThe->thuoctinh->tieuDe;

            $countProductinCart =
                isset($lstCart[$BienTheSizeExist->sku]) ? $lstCart[$BienTheSizeExist->sku]['soluong'] : 0;
            $soLuongTon = $BienTheSizeExist->soLuong - $countProductinCart;
        } else {
            $countProductinCart = isset($lstCart[$sanpham->sku]) ? $lstCart[$sanpham->sku]['soluong'] : 0;
            $soLuongTon = $sanpham->tonKho - $countProductinCart;
        }

        if ($request->soLuong > $soLuongTon) {
            return response()->json([
                'error' => $stringTenSanPham . " hiện chỉ còn " . $soLuongTon . " sản phẩm",
            ]);
        }

        if ($lstCart) {

            if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {

                if (isset($lstCart[$BienTheSizeExist->sku])) {

                    $lstCart[$BienTheSizeExist->sku]['soluong'] = (int)$lstCart[$BienTheSizeExist->sku]['soluong'] +  $request->soLuong;
                    $lstCart[$BienTheSizeExist->sku]['tongTien'] = (int)$lstCart[$BienTheSizeExist->sku]['soluong'] *  (float)$lstCart[$BienTheSizeExist->sku]['gia'];
                } else {
                    $lstCart[$BienTheSizeExist->sku] = array(
                        "id" => $sanpham->id,
                        "tenSanPham" => $stringTenSanPham,
                        'slug' => $sanpham->slug,
                        "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                        "sku" => $BienTheSizeExist->sku,
                        "soluong" => $request->soLuong,
                        "gia" => $BienTheSizeExist->giaKhuyenMai != 0 ?  $BienTheSizeExist->giaKhuyenMai : $BienTheSizeExist->gia,
                        "tongTien" => 0,
                        "bien_the_san_pham_id" => $BienTheSizeExist->id
                    );
                    $lstCart[$BienTheSizeExist->sku]['tongTien'] = (int)$lstCart[$BienTheSizeExist->sku]['soluong'] *  (float)$lstCart[$BienTheSizeExist->sku]['gia'];
                }
                Session::put("Cart", $lstCart);
            } else {
                if (isset($lstCart[$sanpham->sku])) {
                    $lstCart[$sanpham->sku]['soluong'] = (int)$lstCart[$sanpham->sku]['soluong'] +  $request->soLuong;
                    $lstCart[$sanpham->sku]['tongTien'] = (int)$lstCart[$sanpham->sku]['soluong'] *  (float)$lstCart[$sanpham->sku]['gia'];
                } else {
                    $lstCart[$sanpham->sku] = array(
                        "id" => $sanpham->id,
                        "tenSanPham" => $sanpham->tenSanPham,
                        'slug' => $sanpham->slug,
                        "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                        "sku" => $sanpham->sku,
                        "soluong" => $request->soLuong,
                        "gia" => $sanpham->giaKhuyenMai != 0 ?  $sanpham->giaKhuyenMai : $sanpham->gia,
                        "tongTien" => 0,
                        "bien_the_san_pham_id" => null
                    );

                    $lstCart[$sanpham->sku]['tongTien'] = (int)$lstCart[$sanpham->sku]['soluong'] *  (float)$lstCart[$sanpham->sku]['gia'];
                }
                Session::put("Cart", $lstCart);
            }
        } else {

            if ($sanpham->soluongthuoctinh_count && $sanpham->soluongthuoctinh_count > 1) {
                $lstCart[$BienTheSizeExist->sku] = array(
                    "id" => $sanpham->id,
                    "tenSanPham" => $stringTenSanPham,
                    'slug' => $sanpham->slug,
                    "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                    "sku" => $BienTheSizeExist->sku,
                    "soluong" => $request->soLuong,
                    "gia" => $BienTheSizeExist->giaKhuyenMai != 0 ?  $BienTheSizeExist->giaKhuyenMai : $BienTheSizeExist->gia,
                    "tongTien" => 0,
                    "bien_the_san_pham_id" => $BienTheSizeExist->id
                );
                $lstCart[$BienTheSizeExist->sku]['tongTien'] = (int)$lstCart[$BienTheSizeExist->sku]['soluong'] *  (float)$lstCart[$BienTheSizeExist->sku]['gia'];
                Session::put("Cart", $lstCart);
            } else {
                $lstCart[$sanpham->sku] = array(
                    "id" => $sanpham->id,
                    "tenSanPham" => $stringTenSanPham,
                    'slug' => $sanpham->slug,
                    "hinhAnh" => $sanpham->hinhanhs->first()->hinhAnh,
                    "sku" => $sanpham->sku,
                    "soluong" => $request->soLuong,
                    "gia" => $sanpham->giaKhuyenMai != 0 ?  $sanpham->giaKhuyenMai : $sanpham->gia,
                    "tongTien" => 0,
                    "bien_the_san_pham_id" => null
                );
                $lstCart[$sanpham->sku]['tongTien'] = (int)$lstCart[$sanpham->sku]['soluong'] *  (float)$lstCart[$sanpham->sku]['gia'];
                Session::put("Cart", $lstCart);
            }
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
                            ' . number_format($item['gia'], 0, '', '.')  . ' ₫
                        </strong>
                    </a>
                    <a href="#" class="btn-trash action" data-id="' . $item['sku'] . '"><i class="ti-trash"></i></a>
                </li>
            ';
            }
        return response()->json([
            'message' => 'Sản phẩm ' . $stringTenSanPham . ' đã được thêm vào giỏ hàng',
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', '.'),

        ]);
    }

    public function capNhatGioHang(Request $request)
    {

        $lstCart = Session::get('Cart');
        $sku = $request->sanphamId;

        if ($request->type == "incre") {
            // Số lượng tồn kho
            $countProductinCart =
                isset($lstCart[$sku]) ? $lstCart[$sku]['soluong'] : 0;

            if ($lstCart[$sku]['bien_the_san_pham_id']) {
                $bienTheSanPhamCurrent = BienTheSanPham::where([
                    'san_pham_id' => $lstCart[$sku]['id'],
                    'id' => $lstCart[$sku]['bien_the_san_pham_id']
                ])->first();

                $soLuongTon = $bienTheSanPhamCurrent->soLuong - $countProductinCart;
            } else {
                $sanpham = SanPham::where('id', $lstCart[$sku]['id'])->first();
                $soLuongTon = $sanpham->tonKho - $countProductinCart;
            }

            if ($request->soLuong > $soLuongTon) {
                $stringError = "Sản phẩm " . $lstCart[$sku]['tenSanPham'] . " hiện chỉ còn " . $soLuongTon . " sản phẩm ";
                return $this->renderCartTemplate($stringError);
            }
        }

        if ($request->soLuong > 0) {
            if ($request->type == "incre") {
                $lstCart[$sku]['soluong'] += (int)$request->soLuong;
                $lstCart[$sku]['tongTien'] = (int)$lstCart[$sku]['soluong'] *  (float)$lstCart[$sku]['gia'];
            } else if ($request->type == "decre") {
                $lstCart[$sku]['soluong'] = (int)$lstCart[$sku]['soluong'] - (int)$request->soLuong;
                $lstCart[$sku]['tongTien'] = (int)$lstCart[$sku]['soluong'] *  (float)$lstCart[$sku]['gia'];
            }
        } else {
            unset($lstCart[$sku]);
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
                    <a href="#"  class="btn-trash action" data-id="' . $item['sku'] . '"><i class="ti-trash"></i></a>
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
                            <strong>' . number_format($item['gia'], 0, '', '.')   . ' ₫</strong>
                        </td>
                        <td>
                            <div class="numbers-row">
                                <input type="text" value=" ' . $item['soluong'] . ' " id="quantity_1" class="qty2" name="quantity_1">
                            <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                        </td>
                        <td>
                            <strong>' . number_format($item['tongTien'], 0, '', '.')  . '  ₫</strong>
                        </td>
                        <td class="options">
                            <a href="#" class="btn-trash" data-id="' . $item['sku'] . '"><i class="ti-trash"></i></a>
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
            $code = MaGiamGia::where('id', (int)$discountCode["id"])->first();

            if ($code->soLuong <= 0 && $code->soLuong != null && $code->soLuong) {
                Session::forget('DiscountCode');
                $discountCode = null;
            }

            if ($code->giaTriToiThieu != null && $total < $code->giaTriToiThieu) {
                Session::forget('DiscountCode');
                $discountCode = null;
            }
        }

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
            'total' => number_format($total, 0, '', '.'),
            'discount' =>
            number_format($valueDiscount, 0, '', '.'),
            'success' => $valueDiscount != 0 ? 'Áp dụng mã giảm giá thành công' : 'Cập nhật giỏ hàng thành công',
            'newTotal' =>
            number_format($newTotal, 0, '', '.'),
            'error' => $error
        ]);
    }

    public function xoaGioHang(Request $request)
    {
        $sku = $request->sanphamId;
        $lstCart = Session::get('Cart');
        if ($lstCart) {
            if (isset($lstCart[$sku])) {
                unset($lstCart[$sku]);
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
                number_format($valueDiscount != 0 ? -$valueDiscount : $valueDiscount, 0, '', '.'),
                'lstDanhMuc' => $lstDanhMuc,
                'lstDanhMucHeader' => $lstDanhMucHeader
            ]);
        }

        return redirect()->route('user.login')->withErrors('Bạn cần đăng nhập để tiếp tục');
    }

    public function checkout(Request $request)
    {
        $Cart = Session::get('Cart');
        if (!$Cart) {
            return redirect()->route('gio-hang');
        }

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

        if ($request->filled('soDienThoai_billing')) {
            $request->validate([
                'soDienThoai_billing' => 'regex:/((09|03|07|08|05)+([0-9]{8,9})\b)/'
            ], [
                'soDienThoai_billing.regex' => 'Số điện thoại không hợp lệ'
            ]);
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

            if ($discountCode) {
                $hoadon->ma_giam_gia_id = $discountCode['id'];
                $hoadon->save();
            }

            $newArray = [];

            foreach ($Cart as $item) {
                array_push($newArray, [
                    'tenSanPham' => $item['tenSanPham'],
                    'soLuong' => $item['soluong'],
                    'donGia' => $item['gia'],
                    'tongTien' => $item['gia'] * $item['soluong'],
                ]);

                // Sản phẩm
                if ($item['bien_the_san_pham_id'] != null) {
                    $bienTheSanPham = BienTheSanPham::where([
                        'id' => $item['bien_the_san_pham_id'],
                        'san_pham_id' => $item['id']
                    ])->where('soLuong', '>', 0)->first();
                    $bienTheSanPham->soLuong = $bienTheSanPham->soLuong -
                        $item['soluong'];
                    $bienTheSanPham->save();

                    // Thêm chi tiết hoá đơn
                    $chiTietHoaDon = new ChiTietHoaDon();
                    $chiTietHoaDon->fill([
                        'hoa_don_id' => $hoadon->id,
                        'san_pham_id' => $item['id'],
                        'soLuong' => $item['soluong'],
                        'donGia' => $item['gia'],
                        'tongTien' => $item['gia'] * $item['soluong'],
                        'bien_the_san_pham_id' => $item['bien_the_san_pham_id']
                    ]);
                    $chiTietHoaDon->save();
                } else {
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
                }

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

            return
                back()->withErrors([
                    'error' => 'Đã xảy ra lỗi. Chúng tôi thành thật xin lỗi vì điều này !. Một vài sản phẩm trong giỏ hàng của bạn có thể đã hết hàng',
                ]);
        }


        $valueDiscount = 0;
        $infoPayMent = array(
            "thanhTien" => number_format($total, 0, '', '.')  . " ₫",
            "vanChuyen" => number_format(0, 0, '', '.')  . " ₫",
            "giamGia" => number_format(0, 0, '', '.')  . " ₫",
            "tongCong" => number_format(0, 0, '', '.')  . " ₫",
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

        $infoPayMent["giamGia"] = number_format($valueDiscount, 0, '', '.')  . " ₫";
        $infoPayMent["tongCong"] = number_format($total, 0, '', '.')  . " ₫";

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
        $checkUseDiscount = HoaDon::where([
            'khach_hang_id' => Auth()->user()->id,
            'ma_giam_gia_id' => $code->id
        ])->first();

        if ($checkUseDiscount) {
            return response()->json([
                'error' => 'Bạn đã sử dụng mã giảm giá này rồi !',
            ]);
        }
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

        $Cart = Session::get('Cart');
        $total = 0;
        if ($Cart)
            foreach ($Cart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
            }

        if ($code->soLuong <= 0 && $code->soLuong != null && $code->soLuong) {
            return response()->json(['error' => 'Lượt sử dụng mã đã hết, vui lòng sử dụng mã khác']);
        }

        if ($code->giaTriToiThieu != null && $total < $code->giaTriToiThieu) {
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
}
