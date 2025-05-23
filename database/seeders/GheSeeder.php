<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GheSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ghes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $gheData = [];

        // Tạo ghế cho 5 phòng
        for ($phong = 1; $phong <= 5; $phong++) {
            // Hàng A
            for ($i = 1; $i <= 12; $i++) {
                $gheData[] = [
                    'ten_ghe' => 'A' . $i,
                    'phong_id' => $phong,
                    'hang' => 1,
                    'cot' => $i,
                    'loai_ghe' => ($i >= 4 && $i <= 9) ? 1 : 0, // Ghế giữa là VIP
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Hàng B
            for ($i = 1; $i <= 12; $i++) {
                $gheData[] = [
                    'ten_ghe' => 'B' . $i,
                    'phong_id' => $phong,
                    'hang' => 2,
                    'cot' => $i,
                    'loai_ghe' => ($i >= 3 && $i <= 10) ? 1 : 0, // Ghế giữa là VIP
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Hàng C
            for ($i = 1; $i <= 12; $i++) {
                $gheData[] = [
                    'ten_ghe' => 'C' . $i,
                    'phong_id' => $phong,
                    'hang' => 3,
                    'cot' => $i,
                    'loai_ghe' => ($i >= 3 && $i <= 10) ? 1 : 0, // Ghế giữa là VIP
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Hàng D
            for ($i = 1; $i <= 12; $i++) {
                $gheData[] = [
                    'ten_ghe' => 'D' . $i,
                    'phong_id' => $phong,
                    'hang' => 4,
                    'cot' => $i,
                    'loai_ghe' => 0, // Tất cả ghế hàng D là ghế thường
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Hàng E
            for ($i = 1; $i <= 6; $i++) {
                $gheData[] = [
                    'ten_ghe' => 'E' . $i,
                    'phong_id' => $phong,
                    'hang' => 5,
                    'cot' => $i,
                    'loai_ghe' => 2, // Tất cả ghế hàng E là ghế đôi
                    'trang_thai' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chèn dữ liệu vào bảng
        foreach (array_chunk($gheData, 50) as $chunk) {
            DB::table('ghes')->insert($chunk);
        }
    }
}
