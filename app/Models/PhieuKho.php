<?php

namespace App\Models;

use App\Models\NhaCungCap;
use App\Models\User;

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

    public function nhacungcap()
    {
        return $this->belongsTo(NhaCungCap::class, 'nha_cung_cap_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
