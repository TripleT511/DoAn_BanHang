<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\ChiTietHoaDon;
use App\Models\DanhMuc;
use App\Models\HoaDon;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class PayMentOnlineController extends Controller
{
    public function paymentVNPay(Request $request)
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

        $user = Auth::user();



        $total = 0;

        foreach ($Cart as $item) {
            $total += (int)$item['soluong'] * (float)$item['gia'];
        }

        $discountCode = Session::get('DiscountCode');
        $oldTotal = $total;
        $valueDiscount = 0;
        $infoPayMent = array(
            "thanhTien" => number_format($total, 0, '', '.')  . " ₫",
            "vanChuyen" => number_format(0, 0, '', '.')  . " ₫",
            "giamGia" => number_format(0, 0, '', '.')  . " ₫",
            "tongCong" => number_format(0, 0, '', '.')  . " ₫",
            "hinhThuc" => "Thanh toán qua VNPAY"
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
        $infoPayMent["giamGia"] = number_format($valueDiscount, 0, '', '.')  . " ₫";
        $infoPayMent["tongCong"] = number_format($total, 0, '', '.')  . " ₫";
        Session::put("infoPayMent", $infoPayMent);

        //  Thanh toán VN PAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/thanh-toan-thanh-cong/?khach_hang_id=$user->id&hoTen=$request->hoTen_billing&email=$request->email_billing&diaChi=$request->diaChi_billing&soDienThoai=$request->soDienThoai_billing&ghiChu=$request->ghiChu_billing&thanhtien=$oldTotal&giamgia=$valueDiscount";
        if ($request->socialite != null) {
            $vnp_Returnurl = "http://localhost:8000/thanh-toan-thanh-cong/?khach_hang_id=$user->id&hoTen=$request->hoTen_billing&email=$request->email_billing&diaChi=$request->diaChi_billing&soDienThoai=$request->soDienThoai_billing&ghiChu=$request->ghiChu_billing&thanhtien=$oldTotal&giamgia=$valueDiscount";
        }
        $vnp_TmnCode = "D0D9N7LY"; //Mã website tại VNPAY 
        $vnp_HashSecret = "MQWFQOJLSODQKYSYZEWXEFXDKIJGSEQN"; //Chuỗi bí mật

        $vnp_TxnRef = Str::random(30); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
        $vnp_OrderType = 'billPayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {

            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function checkoutSuccess(Request $request)
    {
        if ($request->has('vnp_Amount')) {

            DB::beginTransaction();

            try {
                $Cart = Session::get('Cart');
                $user = Auth::user();
                $total = $request->vnp_Amount / 100;

                $hoadon = new HoaDon();
                $hoadon->fill([
                    'nhan_vien_id' => null,
                    'khach_hang_id' => $user->id,
                    'hoTen' => $request->hoTen,
                    'email' => $request->email,
                    'diaChi' => $request->diaChi,
                    'soDienThoai' => $request->soDienThoai,
                    'ngayXuatHD' => date('Y-m-d H:i:s'),
                    'tongTien' => $request->thanhtien,
                    'giamGia' => $request->giamgia,
                    'tongThanhTien' => $total,
                    'ghiChu' => $request->ghiChu,
                    'trangThaiThanhToan' => 1,
                    'trangThai' => 0,
                ]);

                $hoadon->save();

                $hoadon->giamGia = $request->giamgia;
                $hoadon->tongThanhTien =
                    $request->vnp_Amount / 100;
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
                }

                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();

                return Redirect::route('checkout')->withErrors([
                    'error' => 'Đã xảy ra lỗi. Một vài sản phẩm bạn đang mua hiện đã hết hàng. 
                    Chúng tôi thành thật xin lỗi vì điều này !.',
                ]);
            }


            $infoPayMent = array(
                "thanhTien" => number_format($request->thanhtien, 0, '', '.')  . " ₫",
                "vanChuyen" => number_format(0, 0, '', '.')  . " ₫",
                "giamGia" => number_format($request->giamgia, 0, '', '.')  . " ₫",
                "tongCong" => number_format($request->vnp_Amount / 100, 0, '', '.')  . " ₫",
                "hinhThuc" => "Thanh toán qua VNPAY"
            );

            $this->dispatch(new SendMail($user, $hoadon, $newArray, $infoPayMent));
            $code = Session::get('DiscountCode');
            if ($code) {
                $maGiamGia = MaGiamGia::whereId($code["id"])->first();
                if ($maGiamGia->soLuong != null) {

                    $maGiamGia->soLuong = $maGiamGia->soLuong - 1;
                    $maGiamGia->save();
                }
            }

            Session::forget("Cart");
            Session::forget("DiscountCode");
        }

        $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
        $lstDanhMucHeader = DanhMuc::where('idDanhMucCha', 0)->with('childs')->orderBy('id')->take(1)->get();
        return view('confirm-checkout', ['lstDanhMuc' => $lstDanhMuc, 'lstDanhMucHeader' => $lstDanhMucHeader]);
    }
}
