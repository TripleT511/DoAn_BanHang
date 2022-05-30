<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhieuKho extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'maDonHang',
        'nha_cung_cap_id',
        'user_id',
        'ngayTao',
        'ghiChu',
        'loaiPhieu',
        'trangThai'
    ];
}
