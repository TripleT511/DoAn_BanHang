<?php

namespace App\Models;

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
        'hoTen',
        'diaChi',
        'email',
        'soDienThoai',
        'ngayXuatHD',
        'tongTien',
        'ghiChu'
    ];
}
