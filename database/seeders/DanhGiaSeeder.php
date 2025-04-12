<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DanhGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('danh_gias')->delete();
        DB::table('danh_gias')->truncate();
        DB::table('danh_gias')->insert([
            [
                'id_phim' => '1',
                'id_khach_hang' => '1',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '2',
                'id_khach_hang' => '2',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '3',
                'id_khach_hang' => '3',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '4',
                'id_khach_hang' => '4',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '5',
                'id_khach_hang' => '5',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '6',
                'id_khach_hang' => '6',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '7',
                'id_khach_hang' => '7',
                'noi_dung' => 'Phim rất hay!',
            ],
            [
                'id_phim' => '8',
                'id_khach_hang' => '8',
                'noi_dung' => 'Phim rất hay!',
            ],




        ]);
    }
}
