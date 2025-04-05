<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuatChieu extends Model
{
    protected $table = 'suat_chieus';

    protected $fillable = [
        'phim_id',
        'phong_id',
        'ngay_chieu',
        'gio_bat_dau',
        'gio_ket_thuc',
        'gia_ve',
        'trang_thai', // 'Sắp chiếu', 'Đang chiếu', 'Đã chiếu', 'Hết vé', 'Hủy'
        'dinh_dang', // '2D', '3D', 'IMAX', v.v.
        'ngon_ngu', // 'Phụ đề', 'Lồng tiếng', 'Nguyên bản'
    ];

    // Quan hệ với Phim
    public function phim()
    {
        return $this->belongsTo(QuanLyPhim::class, 'phim_id');
    }

    // Quan hệ với Phòng
    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }

    // Quan hệ với Chi tiết vé
    public function chiTietVe()
    {
        return $this->hasMany(ChiTietVe::class, 'suat_chieu_id');
    }

    // Kiểm tra số ghế còn trống
    public function soGheConTrong()
    {
        $tongSoGhe = $this->phong->soLuongGhe();
        $soGheDaDat = $this->chiTietVe->count();

        return $tongSoGhe - $soGheDaDat;
    }

    // Kiểm tra suất chiếu có còn vé không
    public function conVe()
    {
        return $this->soGheConTrong() > 0;
    }

    // Kiểm tra suất chiếu đã qua chưa
    public function daQua()
    {
        $ngayGioChieu = $this->ngay_chieu . ' ' . $this->gio_bat_dau;
        return now() > $ngayGioChieu;
    }
}
