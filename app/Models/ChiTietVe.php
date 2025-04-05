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
        'gia_ve',
        'id_hoa_don',
        'gia_tien',
        'id_khach_hang',
        'ghi_chu',
        'tinh_trang'
    ];
    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'id_hoa_don');
    }
}
