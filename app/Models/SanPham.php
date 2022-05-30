<?php

namespace App\Models;

use App\Models\HinhAnh;
use App\Models\DanhMuc;


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
        return $this->hasMany(HinhAnh::class, 'san_pham_id', 'id');
    }

    public function danhmuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id', 'id');
    }
}
