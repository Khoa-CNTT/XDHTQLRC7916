<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheLoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('the_loais')->delete();
        DB::table('the_loais')->insert([
            [

                'ten_the_loai' => 'Hành Động',
                'mo_ta'        => 'Hỗn Chiến Kịch',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Hài Kịch',
                'mo_ta'        => 'Tiếng Cười Sảng Khoái',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Kinh Dị',
                'mo_ta'        => 'Nỗi Sợ Rợn Người',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Viễn Tưởng',
                'mo_ta'        => 'Hành Trình Ngoài Không Gian',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Tình Cảm',
                'mo_ta'        => 'Lãng Mạn Ngọt Ngào',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Phiêu Lưu',
                'mo_ta'        => 'Cuộc Phiêu Lưu Kỳ Thú',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Khoa Học',
                'mo_ta'        => 'Khám Phá Công Nghệ',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Tâm Lý',
                'mo_ta'        => 'Chiều Sâu Nội Tâm',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Hoạt Hình',
                'mo_ta'        => 'Thế Giới Sắc Màu',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Âm Nhạc',
                'mo_ta'        => 'Giai Điệu Trữ Tình',
                'id_chi_tiet_the_loai' => 1,
            ],
            [
                'ten_the_loai' => 'Thể Thao',
                'mo_ta'        => 'Cuộc Đua Khốc Liệt',
                'id_chi_tiet_the_loai' => 1,
            ],

        ]);
    }
}
