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
use App\Http\Controllers\Admin\MaGiamGiaController;

use App\Http\Controllers\GioHangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LuotTimKiemController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PayMentOnlineController;
use App\Models\DanhMuc;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginSocialiteController;
use Illuminate\Http\Request;

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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/', [HomeController::class, 'index'])->name('home');

//

Route::get('/email/verify/{id}/{hash}', function (Request $request) {

    return $request;
})->name('verification.verify');

Route::get('/mail', function () {
    return view('mail.order');
});

Route::get('/gio-hang', [GioHangController::class, 'index'])->name('gio-hang');

Route::get('/render-cart', [GioHangController::class, 'renderCart']);

Route::post('/add-to-cart', [GioHangController::class, 'themgiohang'])->name('add-to-cart');

Route::post('/update-cart', [GioHangController::class, 'capNhatGioHang'])->name('update-cart');

Route::post('/remove-cart', [GioHangController::class, 'xoaGioHang'])->name('remove-cart');

Route::get('/login', function () {
    $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
    return view('user.login', ['lstDanhMuc' => $lstDanhMuc]);
})->name('user.login');

Route::get('/register', function () {
    $lstDanhMuc = DanhMuc::where('idDanhMucCha', null)->with('childs')->orderBy('id', 'desc')->take(5)->get();
    return view('user.register', ['lstDanhMuc' => $lstDanhMuc]);
})->name('user.register');

Route::get('/user-logout', [HomeController::class, 'logoutUser'])->name('user.logout');

Route::post('/dangky', [HomeController::class, 'store'])->name('dangky');

Route::get('auth/google', [LoginSocialiteController::class, 'redirectToGoogle'])->name('login_google');
Route::get('auth/callback/google', [LoginSocialiteController::class, 'handleCallbackgoogle']);
Route::get('auth/facebook', [LoginSocialiteController::class, 'redirectToFB'])->name('login_facebook');
Route::get('auth/callback/facebook', [LoginSocialiteController::class, 'handleCallbackFB']);


Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/san-pham', [HomeController::class, 'lstSanPham'])->name('san-pham');

Route::get('/search', [HomeController::class, 'searchSP'])->name('searchSanPham');

Route::post('/add-discount-code', [GioHangController::class, 'addDiscountCode'])->name('themMaGiamGia');

Route::get('/thanh-toan', [GioHangController::class, 'viewCheckOut'])->name('checkout');

Route::post('/login', [
    HomeController::class,
    'login'
])->name('login');



Route::get('/send-mail', [MailController::class, 'sendMail'])->name('sendMail');


Route::middleware(['isGuest'])->group(function () {

    Route::get('/thong-tin-ca-nhan', [HomeController::class, 'xemThongTin'])->name('xem-thong-in-ca-nhan');

    Route::post('/review', [DanhGiaController::class, 'store']);

    Route::post('/thanh-toan', [GioHangController::class, 'checkout'])->name('thanhtoanDefault');

    Route::post('/thanh-toan-vnpay', [PayMentOnlineController::class, 'paymentVNPay'])->name('paymentVNPay');

    Route::get('/thanh-toan-thanh-cong', [PayMentOnlineController::class, 'checkoutSuccess'])->name('confirm-checkout');
});


Route::prefix('admin')->group(function () {

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
        Route::resource('discount', MaGiamGiaController::class);

        // Mã giảm giá hết hạn
        Route::get('/discount-het-han', [MaGiamGiaController::class, 'indexDie'])->name('maHetHan');


        // *** Tìm kiếm *** //
        Route::get('/slideshow/timkiem', [SliderController::class, 'searchSlider']);
        Route::get('/ncungcap/timkiem', [NhaCungCapController::class, 'searchNCC']);
        Route::get('/binhluan/timkiem', [DanhGiaController::class, 'searchBinhLuan']);
        Route::get('/taikhoan/timkiem', [TaiKhoanController::class, 'searchTaiKhoan']);
        Route::get('/taikhoan/mokhoa{user}', [TaiKhoanController::class, 'moKhoa'])->name('mokhoa');

        Route::get('search/danhmuc', [DanhMucController::class, 'searchDanhMuc'])->name('searchDanhMuc');


        Route::post('/upload-image', [MaGiamGiaController::class, 'upLoadImageEditor'])->name('upLoadImageEditor');


        // *** Tìm kiếm *** //

        //Đổi mật khẩu
        Route::get('/user/{user}/doimatkhau', [TaiKhoanController::class, 'changepass'])->name('changepass');
        Route::post('/user/{user}/doimatkhau', [TaiKhoanController::class, 'doimatkhau'])->name('doimatkhau');


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



        // Thêm Thuộc Tính
        Route::get('/thuoctinhdata/them-thuoc-tinh', [ThuocTinhController::class, 'addThuocTinh']);
    });

    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::get('/logout', [
        HomeController::class,
        'logout'
    ])->name('admin.logout');

    Route::get('/forgot', function () {
        return view('admin.forgot');
    });
});

Route::get('/san-pham-{slug}', [HomeController::class, 'sanpham'])->name('chitietsanpham');
Route::get('/danh-muc-{slug}', [HomeController::class, 'danhmucsanpham'])->name('danhmucsanpham');
