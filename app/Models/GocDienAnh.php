<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GocDienAnh extends Model
{
    use HasFactory;

    protected $table = 'goc_dien_anh';
    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'trang_thai'
    ];
}
