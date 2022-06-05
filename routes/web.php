<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PhanQuyenController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\GioHangController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\NhaCungCapController;
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

    Route::resource('phanquyen', PhanQuyenController::class);
    Route::resource('sanpham', SanPhamController::class);
    Route::resource('danhgia', DanhGiaController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('danhmuc', DanhMucController::class);
    Route::resource('nhacungcap', NhaCungCapController::class);


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
