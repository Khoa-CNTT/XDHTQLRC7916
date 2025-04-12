<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạm thời tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa dữ liệu cũ
        DB::table('phongs')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Thêm dữ liệu phòng
        DB::table('phongs')->insert([
            [
                'ten_phong' => 'Phòng chiếu 1',

                'tinh_trang' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'ten_phong' => 'Phòng chiếu 2',

                'tinh_trang' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
