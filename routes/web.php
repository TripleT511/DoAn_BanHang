<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PhanQuyenController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\GioHangController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\NhaCungCapController;
use App\Http\Controllers\Admin\PhieuKhoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TaiKhoanController;
use App\Http\Controllers\Admin\ThuocTinhController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/user', function () {
    return view('user');
});

Route::resource('giohang', GioHangController::class);

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/review', function () {
    return view('review');
});

Route::get('/confirm', function () {
    return view('confirm-checkout');
});

Route::get('/account', function () {
    return view('account');
});

Route::get('/list', function () {
    return view('list-product');
});

Route::get('/search', function () {
    return view('search');
});

Route::get('/bai-viet', function () {
    return view('blog');
});

Route::get('/chi-tiet-bai-viet', function () {
    return view('blog-detail');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('taikhoan', TaiKhoanController::class);
    Route::resource('phanquyen', PhanQuyenController::class);
    Route::resource('sanpham', SanPhamController::class);
    Route::resource('danhgia', DanhGiaController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('danhmuc', DanhMucController::class);
    Route::resource('phieukho', PhieuKhoController::class);
    Route::resource('thuoctinh', ThuocTinhController::class);
    Route::resource('nhacungcap', NhaCungCapController::class);



    // Search sản phẩm ( tạo phiếu kho )
    Route::get('/kho/timkiem', [PhieuKhoController::class, 'searchSanPham']);

    // Thêm sản phẩm ( chi tiết phiếu kho )
    Route::get('/kho/them-chi-tiet', [PhieuKhoController::class, 'themChiTietPhieuKho'])->name('themchitietpk');

    // Render giao diện
    Route::get('/kho/xem-chi-tiet', [PhieuKhoController::class, 'renderList'])->name('renderList');

    // Xoá một chi tiết phiếu kho
    Route::get('/kho/xoa-chi-tiet', [PhieuKhoController::class, 'xoaChiTietPhieuKho'])->name('xoaChiTietPhieuKho');

    // Cập nhật chi tiết phiếu kho
    Route::get('/kho/cap-nhat-chi-tiet', [PhieuKhoController::class, 'updateChiTietPhieuKho'])->name('updateChiTietPhieuKho');

    // Xem phiếu kho
    Route::get('/kho/xem-phieu-kho', [PhieuKhoController::class, 'xemPhieuKho'])->name('xemPhieuKho');


    // === Thuộc Tính === //

    // Get Thuộc Tính
    Route::get('/thuoctinhdata/lay-danh-sach-thuoc-tinh', [ThuocTinhController::class, 'getAllThuocTinh']);

    // Thêm Thuộc Tính
    Route::get('/thuoctinhdata/them-thuoc-tinh', [ThuocTinhController::class, 'addThuocTinh']);

    // === Thuộc Tính === //


    Route::get('/login', function () {
        return view('admin.login');
    })->name('adminlogin');;

    Route::post('/login', [
        HomeController::class,
        'login'
    ])->name('login');

    Route::get('/logout', [
        HomeController::class,
        'logout'
    ])->name('logout');

    Route::get('/forgot', function () {
        return view('admin.forgot');
    });
});
