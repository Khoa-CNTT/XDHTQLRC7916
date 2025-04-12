<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuatChieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //     DB::table('suat_chieus')->delete();
        //     DB::table('suat_chieus')->truncate();
        //     DB::table('suat_chieus')->insert([
        //         [
        //             'id_suat' => 'S01',
        //             'thoi_gian_bat_dau' => '2024-10-10 08:00:00',
        //             'thoi_gian_ket_thuc' => '2024-10-10 10:00:00',
        //             'id_phim' => 'P001',
        //             'tinh_trang' => 1,
        //         ],
        //         [
        //             'id_suat' => 'S02',
        //             'thoi_gian_bat_dau' => '2024-10-10 12:00:00',
        //             'thoi_gian_ket_thuc' => '2024-10-10 14:00:00',
        //             'id_phim' => 'P002',
        //             'tinh_trang' => 0,
        //         ],
        //         [
        //             'id_suat' => 'S03',
        //             'thoi_gian_bat_dau' => '2024-10-10 16:00:00',
        //             'thoi_gian_ket_thuc' => '2024-10-10 18:00:00',
        //             'id_phim' => 'P003',
        //             'tinh_trang' => 1,
        //         ],
        //     ]);
    }
}
