<?php

namespace App\Models;

use App\Models\HinhAnh;
use App\Models\DanhMuc;
use App\Models\ChiTietPhieuKho;
use App\Models\BienTheSanPham;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPham extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'sku',
        'danh_muc_id',
        'tenSanPham',
        'noiDung',
        'moTa',
        'dacTrung',
        'gia',
        'giaKhuyenMai',
        'slug',
    ];

    public function hinhanhs()
    {
        return $this->hasMany(HinhAnh::class, 'san_pham_id', 'id')->withTrashed();
    }

    public function danhmuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id', 'id')->withTrashed();
    }

    public function chitietphieukhos()
    {
        return $this->hasMany(ChiTietPhieuKho::class, 'san_pham_id', 'id')->withTrashed();
    }

    public function danhgias()
    {
        return $this->hasMany(DanhGia::class, 'san_pham_id', 'id')->withTrashed();
    }

    public function chitiethoadons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'san_pham_id', 'id')->withTrashed();
    }

    public function soluongthuoctinh()
    {
        return $this->hasMany(ThuocTinhSanPham::class, 'san_pham_id', 'id');
    }

    public function color()
    {
        return $this->hasOne(BienTheSanPham::class, 'san_pham_id', 'id')->with('tuychonbienthe.color');
    }

    public function sizes()
    {
        return $this->hasMany(BienTheSanPham::class, 'san_pham_id', 'id')->with('tuychonbienthe.sizes');
    }
}
