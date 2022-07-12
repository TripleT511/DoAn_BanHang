<?php

namespace App\Models;

use App\Models\SanPham;
use App\Models\TaiKhoan;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhGia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'san_pham_id',
        'user_id',
        'noiDung',
        'xepHang',
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id', 'id')->withTrashed();
    }
    public function taikhoan()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
}
