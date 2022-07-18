<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThuocTinhSanPham extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'san_pham_id',
        'thuoc_tinh_id',
    ];
}
