<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    protected $table = 'dich_vus';

    protected $fillable = [
        'ten_dich_vu',
        'gia_tien',
        'tinh_trang',
        'hinh_anh'
    ];
    public function chiTietVes()
    {
        return $this->belongsToMany(ChiTietVe::class, 'chi_tiet_ve_dich_vus', 'id_dich_vu', 'id_chi_tiet_ve')
            ->withPivot('so_luong')
            ->withTimestamps();
    }
}
