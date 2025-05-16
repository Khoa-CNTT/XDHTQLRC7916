<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheLoaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('the_loais')->delete(); // dùng truncate để xóa sạch và reset id
        DB::table('the_loais')->insert([
            [
                'ten_the_loai' => 'Hành Động',
                'mo_ta'       => 'Hỗn Chiến Kịch',
            ],
            [
                'ten_the_loai' => 'Hài Kịch',
                'mo_ta'       => 'Tiếng Cười Sảng Khoái',
            ],
            [
                'ten_the_loai' => 'Kinh Dị',
                'mo_ta'       => 'Nỗi Sợ Rợn Người',
            ],
            [
                'ten_the_loai' => 'Viễn Tưởng',
                'mo_ta'       => 'Hành Trình Ngoài Không Gian',
            ],
            [
                'ten_the_loai' => 'Tình Cảm',
                'mo_ta'       => 'Lãng Mạn Ngọt Ngào',
            ],
            [
                'ten_the_loai' => 'Phiêu Lưu',
                'mo_ta'       => 'Cuộc Phiêu Lưu Kỳ Thú',
            ],
            [
                'ten_the_loai' => 'Khoa Học',
                'mo_ta'       => 'Khám Phá Công Nghệ',
            ],
            [
                'ten_the_loai' => 'Tâm Lý',
                'mo_ta'       => 'Chiều Sâu Nội Tâm',
            ],
            [
                'ten_the_loai' => 'Hoạt Hình',
                'mo_ta'       => 'Thế Giới Sắc Màu',
            ],
            [
                'ten_the_loai' => 'Âm Nhạc',
                'mo_ta'       => 'Giai Điệu Trữ Tình',
            ],
            [
                'ten_the_loai' => 'Thể Thao',
                'mo_ta'       => 'Cuộc Đua Khốc Liệt',
            ],
        ]);
    }
}
