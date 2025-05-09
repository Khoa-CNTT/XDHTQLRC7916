<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa dữ liệu cũ
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ghes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo dữ liệu ghế cho phòng 1
        $gheData = [];

        // Hàng A - Phòng 1
        for ($i = 1; $i <= 12; $i++) {
            $gheData[] = [
                'ten_ghe' => 'A' . $i,
                'phong_id' => 1,
                'hang' => 1,
                'cot' => $i,
                'loai_ghe' => ($i >= 4 && $i <= 9) ? 1 : 0, // Ghế giữa là VIP
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng B - Phòng 1
        for ($i = 1; $i <= 12; $i++) {
            $gheData[] = [
                'ten_ghe' => 'B' . $i,
                'phong_id' => 1,
                'hang' => 2,
                'cot' => $i,
                'loai_ghe' => ($i >= 3 && $i <= 10) ? 1 : 0, // Ghế giữa là VIP
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng C - Phòng 1
        for ($i = 1; $i <= 12; $i++) {
            $gheData[] = [
                'ten_ghe' => 'C' . $i,
                'phong_id' => 1,
                'hang' => 3,
                'cot' => $i,
                'loai_ghe' => ($i >= 3 && $i <= 10) ? 1 : 0, // Ghế giữa là VIP
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng D - Phòng 1
        for ($i = 1; $i <= 12; $i++) {
            $gheData[] = [
                'ten_ghe' => 'D' . $i,
                'phong_id' => 1,
                'hang' => 4,
                'cot' => $i,
                'loai_ghe' => 0, // Tất cả ghế hàng D là ghế thường
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Hàng E - Phòng 1
        for ($i = 1; $i <= 6; $i++) {
            $gheData[] = [
                'ten_ghe' => 'E' . $i,
                'phong_id' => 1,
                'hang' => 4,
                'cot' => $i,
                'loai_ghe' => 2, // Tất cả ghế hàng D là ghế thường
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng A - Phòng 2
        for ($i = 1; $i <= 10; $i++) {
            $gheData[] = [
                'ten_ghe' => 'A' . $i,
                'phong_id' => 2,
                'hang' => 1,
                'cot' => $i,
                'loai_ghe' => ($i >= 3 && $i <= 8) ? 1 : 0, // Ghế giữa là VIP
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng B - Phòng 2
        for ($i = 1; $i <= 10; $i++) {
            $gheData[] = [
                'ten_ghe' => 'B' . $i,
                'phong_id' => 2,
                'hang' => 2,
                'cot' => $i,
                'loai_ghe' => ($i >= 3 && $i <= 8) ? 1 : 0, // Ghế giữa là VIP
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng C - Phòng 2
        for ($i = 1; $i <= 10; $i++) {
            $gheData[] = [
                'ten_ghe' => 'C' . $i,
                'phong_id' => 2,
                'hang' => 3,
                'cot' => $i,
                'loai_ghe' => 0, // Tất cả ghế hàng C là ghế thường
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Hàng D - Phòng 2
        for ($i = 1; $i <= 10; $i++) {
            $gheData[] = [
                'ten_ghe' => 'D' . $i,
                'phong_id' => 2,
                'hang' => 4,
                'cot' => $i,
                'loai_ghe' => 2, // Tất cả ghế hàng D là ghế đôi
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Hàng E - Phòng 2
        for ($i = 1; $i <= 5; $i++) {
            $gheData[] = [
                'ten_ghe' => 'E' . $i,
                'phong_id' => 2,
                'hang' => 4,
                'cot' => $i,
                'loai_ghe' => 2, // Tất cả ghế hàng D là ghế đôi
                'trang_thai' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Chèn dữ liệu vào bảng
        foreach (array_chunk($gheData, 50) as $chunk) {
            DB::table('ghes')->insert($chunk);
        }
    }
}
