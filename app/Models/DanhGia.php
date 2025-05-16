<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gias';

    protected $fillable = [
        'id_phim',
        'id_khach_hang',
        'noi_dung',
    ];
}
