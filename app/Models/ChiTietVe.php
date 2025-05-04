<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietVe extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_ves';
    protected $fillable = [
        'id_suat',
        'id_ghe',
        'id_chi_tiet_ve_dich_vu',
        'gia_ve',
        'id_hoa_don',
        'gia_tien',
        'id_khach_hang',
        'ghi_chu',
        'tinh_trang',
        'checked_in'
    ];
    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'id_hoa_don');
    }
    public function dichVus()
    {
        return $this->belongsToMany(DichVu::class, 'chi_tiet_ve_dich_vus', 'id_chi_tiet_ve', 'id_dich_vu')
            ->withPivot('so_luong')
            ->withTimestamps();
    }
    public function ghe()
    {
        return $this->belongsTo(Ghe::class, 'id_ghe', 'id');
    }
}
