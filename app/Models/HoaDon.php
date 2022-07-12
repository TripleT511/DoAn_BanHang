<?php

namespace App\Models;

use App\Models\User;
use App\Models\ChiTietHoaDon;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HoaDon extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nhan_vien_id',
        'khach_hang_id',
        'ma_giam_gia_id',
        'hoTen',
        'diaChi',
        'email',
        'soDienThoai',
        'ngayXuatHD',
        'tongTien',
        'ghiChu',
        'trangThaiThanhToan',
        'trangThai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nhan_vien_id', 'id')->withTrashed();
    }

    public function khachhang()
    {
        return $this->belongsTo(User::class, 'khach_hang_id', 'id')->withTrashed();
    }

    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'hoa_don_id', 'id')->withTrashed();
    }
}
