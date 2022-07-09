<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\SanPham;
use App\Models\HoaDon;

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

    public function hoadon()
    {
        return $this->belongsTo(HoaDon::class, 'hoa_don_id', 'id');
    }


    public function hoadonSuccess()
    {
        return $this->belongsTo(HoaDon::class, 'hoa_don_id', 'id')->where('trangThai', 4);
    }


    public function hoadonCancel()
    {
        return $this->belongsTo(HoaDon::class, 'hoa_don_id', 'id')->where('trangThai', 5);
    }
}
