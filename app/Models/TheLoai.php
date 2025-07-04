<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    use HasFactory;

    protected $table = 'the_loais';
    protected $fillable = [
        'ten_the_loai',
        'mo_ta',
    ];

    public function phims()
    {
        return $this->belongsToMany(QuanLyPhim::class, 'chi_tiet_the_loais', 'id_the_loai', 'id_phim');
    }
}
