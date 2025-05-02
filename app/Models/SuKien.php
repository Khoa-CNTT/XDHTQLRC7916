<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuKien extends Model
{
    use HasFactory;

    protected $table = 'su_kiens';
    protected $fillable = [
        'ten_su_kien',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'mo_ta',
        'tinh_trang',
        'hinh_anh',
    ];

}
