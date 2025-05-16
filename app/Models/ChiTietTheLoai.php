<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietTheLoai extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_the_loais';
    protected $fillable = [
        'id_the_loai',
        'id_phim',
        'mo_ta'
    ];
}
