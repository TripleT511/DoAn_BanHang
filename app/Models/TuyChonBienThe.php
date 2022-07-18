<?php

namespace App\Models;

use App\Models\TuyChonThuocTinh;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuyChonBienThe extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'bien_the_san_pham_id',
        'tuy_chon_thuoc_tinh_id',
    ];

    public function thuoctinh()
    {
        return $this->belongsTo(TuyChonThuocTinh::class, 'tuy_chon_thuoc_tinh_id', 'id')->withTrashed();
    }

    public function color()
    {
        return $this->belongsTo(TuyChonThuocTinh::class, 'tuy_chon_thuoc_tinh_id', 'id')->where('thuoc_tinh_id', 2)->withTrashed();
    }

    public function sizes()
    {
        return $this->belongsTo(TuyChonThuocTinh::class, 'tuy_chon_thuoc_tinh_id', 'id')->where('thuoc_tinh_id', 1)->withTrashed();
    }
}
