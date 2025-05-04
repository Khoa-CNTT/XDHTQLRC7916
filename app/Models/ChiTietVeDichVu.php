<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietVeDichVu extends Model
{
    protected $table = 'chi_tiet_ve_dich_vus';
    protected $fillable = ['id_chi_tiet_ve', 'id_dich_vu', 'so_luong', 'gia_tien', 'check_in_dich_vu','thoi_gian_check_in_dich_vu'];

    public function chiTietVe()
    {
        return $this->belongsTo(ChiTietVe::class, 'id_chi_tiet_ve', 'id');
    }

    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'id_dich_vu', 'id');
    }
}
