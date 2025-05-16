<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baner extends Model
{
    protected $table = 'baners';
    protected $flillable = [
        'id_phim',
        'hinh_anh',
        'tinh_trang',
    ];
}
