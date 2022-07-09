<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrangNoiDung extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tieuDe',
        'slug',
        'noiDung'
    ];
}
