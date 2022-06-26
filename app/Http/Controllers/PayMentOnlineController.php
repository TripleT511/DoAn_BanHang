<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\ChiTietHoaDon;
use App\Models\GioHang;
use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class PayMentOnlineController extends Controller
{
    public function paymentVNPay(Request $request)
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

        $user = Auth::user();
        $hoadon = [];

        $hoadon = array(
            'khach_hang_id' => $user->id,
            'hoTen' => $request->hoTen_billing,
            'email' => $request->email_billing,
            'diaChi' => $request->diaChi_billing,
            'soDienThoai' => $request->soDienThoai_billing,
            'ghiChu' => $request->ghiChu_billing,
        );

        Session::forget("HoaDon");
        Session::put("HoaDon", $hoadon);

        //  Thanh toán VN PAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/thanh-toan-thanh-cong";
        $vnp_TmnCode = ""; //Mã website tại VNPAY 
        $vnp_HashSecret = ""; //Chuỗi bí mật

        $vnp_TxnRef = Str::random(30); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
        $vnp_OrderType = 'billPayment';
        $vnp_Amount = $request->tongTien * 100;
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
            "vnp_TxnRef" => $vnp_TxnRef
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
            $hoadonSS = Session::get('HoaDon');

            $Cart = Session::get('Cart');
            $user = Auth::user();
            $total = $request->vnp_Amount / 100;

            $hoadon = new HoaDon();
            $hoadon->fill([
                'nhan_vien_id' => null,
                'khach_hang_id' => $user->id,
                'hoTen' => $hoadonSS['hoTen'],
                'email' => $hoadonSS['email'],
                'diaChi' => $hoadonSS['diaChi'],
                'soDienThoai' => $hoadonSS['soDienThoai'],
                'ngayXuatHD' => date('Y-m-d H:i:s'),
                'tongTien' => $total,
                'ghiChu' => $hoadonSS['ghiChu'],
                'trangThai' => 4,
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
            }

            $this->dispatch(new SendMail($user, $hoadon, $newArray));

            Session::forget("Cart");
        }

        return view('confirm-checkout');
    }
}