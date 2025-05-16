<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class KhachHang extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'khach_hangs';

    protected $fillable = [
        'ten_khach_hang',
        'email',
        'so_dien_thoai',
        'password',
        'hash_active',
        'hash_reset',
        'is_block',
        'is_active',
        'ngay_sinh',
        're_password',
        'google_id'
    ];
}
