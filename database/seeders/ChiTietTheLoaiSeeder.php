<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietTheLoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::table('chi_tiet_the_loais')->truncate();

        // Dữ liệu mẫu: mỗi phim có nhiều thể loại khác nhau
        $data = [
            ['id_phim' => 1, 'id_the_loai' => 1],
            ['id_phim' => 1, 'id_the_loai' => 2],
            ['id_phim' => 2, 'id_the_loai' => 1],
            ['id_phim' => 2, 'id_the_loai' => 3],
            ['id_phim' => 3, 'id_the_loai' => 2],
        ];

        // Chèn dữ liệu (không bị trùng khóa chính)
        DB::table('chi_tiet_the_loais')->insert($data);
    }
}
