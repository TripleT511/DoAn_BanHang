<?php

namespace App\Models;

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
        'moTa',
        'dacTrung',
        'gia',
        'giaKhuyenMai',
    ];
}
