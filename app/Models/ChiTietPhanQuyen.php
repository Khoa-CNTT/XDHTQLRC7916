<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhanQuyen extends Model
{
    protected $table = 'chi_tiet_phan_quyens';

    protected $fillable = [
        'id_quyen',
        'id_chuc_nang'
    ];
}
