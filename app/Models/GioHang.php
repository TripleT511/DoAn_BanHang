<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GioHang extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'san_pham_id',
        'user_id',
        'soLuong',
    ];
}
