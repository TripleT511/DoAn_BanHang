<?php

use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\GioHangController;
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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('phanQuyen', PhanQuyenController::class);
    Route::resource('sanpham', SanPhamController::class);
    Route::get('/login', function () {
        return view('admin.login');
    });

    Route::get('/forgot', function () {
        return view('admin.forgot');
    });

    Route::get('/taikhoan', function () {
        return view('admin.taikhoan.index-taikhoan');
    });

    Route::get('/taikhoan/create', function () {
        return view('admin.taikhoan.create-taikhoan');
    });

    Route::get('/taikhoan/edit', function () {
        return view('admin.taikhoan.edit-taikhoan');
    });
});
