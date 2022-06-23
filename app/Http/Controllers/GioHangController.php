<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Http\Requests\StoreGioHangRequest;
use App\Http\Requests\UpdateGioHangRequest;
use App\Jobs\SendMail;
use App\Mail\OrderMail;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietPhieuKho;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


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
                    <a href="#0" class="action"><i class="ti-trash"></i></a>
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
        $idSanPham = $request->sanphamId;
        $sanpham = SanPham::whereId($idSanPham)->first();
        $lstCart = Session::get('Cart');
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
                    "gia" => $sanpham->gia,
                    "tongTien" => $sanpham->gia
                );
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
                "gia" => $sanpham->gia,
                "tongTien" => $sanpham->gia
            );
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
                    <a href="#0" class="action" data-id="' . $item['id'] . '"><i class="ti-trash"></i></a>
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
        $idSanPham = $request->sanphamId;
        $lstCart = Session::get('Cart');
        if ($request->soLuong > 0) {
            $lstCart[$idSanPham]['soluong'] = (int)$request->soLuong;
            $lstCart[$idSanPham]['tongTien'] = (int)$request->soLuong *  (float)$lstCart[$idSanPham]['gia'];
            Session::put("Cart", $lstCart);
        } else {
            unset($lstCart[$idSanPham]);
        }
        return $this->renderCartTemplate();
    }

    public function renderCartTemplate()
    {

        $newCart = Session::get('Cart');
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
                    <a href="#0" class="action"><i class="ti-trash"></i></a>
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

        return response()->json([
            'cartMain' => $outputMain,
            'newCart' => $output,
            'numberCart' => $newCart ? count($newCart) : 0,
            'total' => number_format($total, 0, '', ','),
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

        return $this->renderCartTemplate();
    }


    public function index(Request $request)
    {

        $Cart = Session::get('Cart');
        $countCart = $Cart ? count($Cart) : 0;
        $total = 0;
        if ($Cart)
            foreach ($Cart as $item) {
                $total += (float)$item['gia'] * (int)$item['soluong'];
            }
        return view('cart', [
            'Cart' => $Cart ? $Cart : [],
            'countCart' => $countCart,
            'total' => $total
        ]);
    }

    public function viewCheckOut(Request $request)
    {
        if (Auth::check() && Auth::user()->phan_quyen_id == 2) {

            $Cart = Session::get('Cart');
            $countCart = $Cart ? count($Cart) : 0;
            $total = 0;
            if ($Cart)
                foreach ($Cart as $item) {
                    $total += (float)$item['gia'] * (int)$item['soluong'];
                }

            return view('checkout', [
                'user' => Auth::user(),
                'Cart' => $Cart ? $Cart : [],
                'countCart' => $countCart,
                'total' => $total
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

            $total = (int)$item['soluong'] * (float)$item['gia'];
        }

        $hoadon->tongTien = $total;
        $hoadon->save();

        $this->dispatch(new SendMail($user, $hoadon, $newArray));

        Session::flush('Cart');
        return view('confirm-checkout');
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
