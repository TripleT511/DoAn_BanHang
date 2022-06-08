<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuyChonThuocTinh extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'thuoc_tinh_id',
        'tieuDe',
        'mauSac'
    ];

    public function thuoctinh()
    {
        return $this->belongsTo(ThuocTinh::class, 'thuoc_tinh_id', 'id');
    }
}
