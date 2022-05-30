<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChiTietPhieuKho extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'phieu_kho_id',
        'san_pham_id',
        'sku',
        'donVi',
        'soLuong',
        'gia',
        'tongTien'
    ];
}
