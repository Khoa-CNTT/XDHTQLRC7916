<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_dons';

    protected $fillable = [
        'ma_hoa_don',
        'id_khach_hang',
        'id_nhan_vien',
        'id_suat',
        'tong_tien',
        'phuong_thuc_thanh_toan',
        'trang_thai',
        'ngay_thanh_toan',
        'ghi_chu'
    ];

    // Thêm relationship với SuatChieu
    public function suatChieu()
    {
        return $this->belongsTo(SuatChieu::class, 'id_suat', 'id');
    }

    // Thêm relationship với ChiTietVe
    public function chiTietVes()
    {
        return $this->hasMany(ChiTietVe::class, 'id_hoa_don', 'id');
    }

    // Thêm relationship với KhachHang
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'id_khach_hang', 'id');
    }
}
