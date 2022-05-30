<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class PhanQuyen extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tenViTri',
        'viTri',
    ];
}
