<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChiTietHoaDon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hoa_don_id',
        'san_pham_id',
        'soLuong',
        'donGia'
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id', 'id');
    }
}
