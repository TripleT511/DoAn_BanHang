<?php

use App\Http\Controllers\Admin\DanhMucController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PhanQuyenController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\NhaCungCapController;
use App\Http\Controllers\Admin\PhieuKhoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TaiKhoanController;
use App\Http\Controllers\Admin\ThuocTinhController;
use App\Http\Controllers\Admin\HoaDonController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/mail', function () {
    return view('mail.order');
});

Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gio-hang');

Route::get('/render-cart', [GioHangController::class, 'renderCart']);

Route::post('/add-to-cart', [GioHangController::class, 'themgiohang'])->name('add-to-cart');

Route::post('/update-cart', [GioHangController::class, 'capNhatGioHang'])->name('update-cart');

Route::post('/remove-cart', [GioHangController::class, 'xoaGioHang'])->name('remove-cart');

Route::get('/login', function () {
    return view('user.login');
})->name('user.login');

Route::get('/register', function () {
    return view('user.register');
})->name('user.register');


Route::get('/san-pham', function () {
    return view('san-pham');
});


Route::get('/thanh-toan-thanh-cong', function () {
    return view('confirm-checkout');
})->name('confirm-checkout');


// Route::get('/search', function () {
//     return view('search');
// });

// Route::get('/bai-viet', function () {
//     return view('blog');
// });

// Route::get('/chi-tiet-bai-viet', function () {
//     return view('blog-detail');
// });

Route::get('/thanh-toan', [GioHangController::class, 'viewCheckOut'])->name('checkout');

Route::post('/login', [
    HomeController::class,
    'login'
])->name('login');

Route::get('/logout', [
    HomeController::class,
    'logout'
])->name('logout');

Route::get('/send-mail', [MailController::class, 'sendMail'])->name('sendMail');

Route::middleware(['isGuest'])->group(function () {
    Route::get('/user', function () {
        return view('user');
    });

    Route::post('/review', [DanhGiaController::class, 'store']);

    Route::post('/thanh-toan', [GioHangController::class, 'checkout']);
});


Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('isAdmin');

    Route::get('/thong-ke', [DashboardController::class, 'thongKeDoanhThu']);

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('user', TaiKhoanController::class);
        Route::resource('phanquyen', PhanQuyenController::class);
        Route::resource('sanpham', SanPhamController::class);
        Route::resource('danhgia', DanhGiaController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('danhmuc', DanhMucController::class);
        Route::resource('phieukho', PhieuKhoController::class);
        Route::resource('thuoctinh', ThuocTinhController::class);
        Route::resource('nhacungcap', NhaCungCapController::class);
        Route::resource('hoadon', HoaDonController::class);


        // *** Tìm kiếm *** //
        Route::get('/slideshow/timkiem', [SliderController::class, 'searchSlider']);
        Route::get('/ncungcap/timkiem', [NhaCungCapController::class, 'searchNCC']);
        Route::get('/binhluan/timkiem', [DanhGiaController::class, 'searchBinhLuan']);
        Route::get('/taikhoan/timkiem', [TaiKhoanController::class, 'searchTaiKhoan']);
        Route::get('/taikhoan/mokhoa{user}', [TaiKhoanController::class, 'moKhoa'])->name('mokhoa');
        Route::get('/dmuc/timkiem', [DanhMucController::class, 'searchDanhMuc']);

        // *** Tìm kiếm *** //

        // Search sản phẩm ( tạo phiếu kho )
        Route::get('/kho/timkiem', [PhieuKhoController::class, 'searchSanPham']);

        // Chọn sản phẩm
        Route::get('/kho/chon', [PhieuKhoController::class, 'chonSanPham']);

        // Thêm chi tiết phiếu kho 
        Route::get('/kho/them-chi-tiet', [PhieuKhoController::class, 'themChiTietPhieuKho'])->name('themchitietpk');

        // Thêm sản phẩm trong chi tiết phiếu kho 
        Route::post('/kho/them-san-pham', [PhieuKhoController::class, 'themSanPham'])->name('themSanPham');

        // Render giao diện
        Route::get('/kho/xem-chi-tiet', [PhieuKhoController::class, 'renderList'])->name('renderList');

        // Xoá một chi tiết phiếu kho
        Route::get('/kho/xoa-chi-tiet', [PhieuKhoController::class, 'xoaChiTietPhieuKho'])->name('xoaChiTietPhieuKho');

        // Cập nhật chi tiết phiếu kho
        Route::get('/kho/cap-nhat-chi-tiet', [PhieuKhoController::class, 'updateChiTietPhieuKho'])->name('updateChiTietPhieuKho');

        // Xem phiếu kho
        Route::get('/kho/xem-phieu-kho', [PhieuKhoController::class, 'xemPhieuKho'])->name('xemPhieuKho');



        // Get Thuộc Tính
        Route::get('/thuoctinhdata/lay-danh-sach-thuoc-tinh', [ThuocTinhController::class, 'getAllThuocTinh']);

        // Thêm Thuộc Tính
        Route::get('/thuoctinhdata/them-thuoc-tinh', [ThuocTinhController::class, 'addThuocTinh']);
    });

    Route::get('/login', function () {
        return view('admin.login');
    })->name('adminlogin');



    Route::get('/forgot', function () {
        return view('admin.forgot');
    });
});

Route::get('/{slug}', [HomeController::class, 'sanpham'])->name('chitietsanpham');
