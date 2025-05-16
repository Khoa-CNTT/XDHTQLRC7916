<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    protected $table = "phan_quyens";
        protected $fillable = [
        'ten_quyen',
        'is_quyen',
        ];
}
