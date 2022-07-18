<?php

namespace App\Models;

use App\Models\TuyChonBienThe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BienTheSanPham extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'san_pham_id',
        'sku',
        'gia',
        'giaKhuyenMai',
        'soLuong'
    ];


    public function tuychonbienthe()
    {
        return $this->belongsTo(TuyChonBienThe::class, 'id', 'bien_the_san_pham_id');
    }
}
