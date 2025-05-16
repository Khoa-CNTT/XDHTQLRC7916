<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class NhanVien extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'nhan_viens';

    protected $fillable = [
        'ten_nhan_vien',
        'ngay_sinh',
        'sdt',
        'email',
        'password',
        'ngay_bat_dau',
        'id_chuc_vu',
        'avatar',
        'tinh_trang',
        'is_master',
    ];
}
