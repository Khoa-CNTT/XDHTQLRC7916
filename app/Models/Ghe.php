<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ghe extends Model
{
    protected $table = "ghes";
    protected $fillable = [
        'ten_ghe',
        'phong_id',  // Đảm bảo tên trường khớp với migration
        'hang',      // Thêm trường hàng
        'cot',       // Thêm trường cột
        'loai_ghe',  // Thêm trường loại ghế
        'trang_thai',
    ];

    // Định nghĩa quan hệ với Phong
    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id', 'id');
    }

    // Định nghĩa quan hệ với ChiTietVe
    public function chiTietVe()
    {
        return $this->hasMany(ChiTietVe::class, 'id_ghe', 'id');
    }

    // Kiểm tra ghế đã được đặt trong suất chiếu cụ thể
    public function daDat($suatChieuId)
    {
        return $this->chiTietVe()
            ->where('id_suat', $suatChieuId)
            ->where('tinh_trang', 1)
            ->exists();
    }
}
