<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhMuc extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenDanhMuc',
        'slug',
        'idDanhMucCha',
    ];

    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }


    public function childs()
    {
        return $this->hasMany(DanhMuc::class, 'idDanhMucCha', 'id')->with('childs');
    }
}
