<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietTheLoaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chi_tiet_the_loais')->delete();

        DB::table('chi_tiet_the_loais')->insert([
            // Phim 1
            ['id_phim' => 1, 'id_the_loai' => 1 ],
            ['id_phim' => 1, 'id_the_loai' => 3 ],

            // Phim 2
            ['id_phim' => 2, 'id_the_loai' => 2],
            ['id_phim' => 2, 'id_the_loai' => 5],

            // Phim 3
            ['id_phim' => 3, 'id_the_loai' => 4],
            ['id_phim' => 3, 'id_the_loai' => 6],

            // Phim 4
            ['id_phim' => 4, 'id_the_loai' => 1],
            ['id_phim' => 4, 'id_the_loai' => 7],

            // Phim 5
            ['id_phim' => 5, 'id_the_loai' => 2],
            ['id_phim' => 5, 'id_the_loai' => 9],

            // Phim 6
            ['id_phim' => 6, 'id_the_loai' => 3],
            ['id_phim' => 6, 'id_the_loai' => 10],

            // Phim 7
            ['id_phim' => 7, 'id_the_loai' => 4],
            ['id_phim' => 7, 'id_the_loai' => 8],

            // Phim 8
            ['id_phim' => 8, 'id_the_loai' => 5],
            ['id_phim' => 8, 'id_the_loai' => 6],

            // Phim 9
            ['id_phim' => 9, 'id_the_loai' => 1],
            ['id_phim' => 9, 'id_the_loai' => 9],

            // Phim 10
            ['id_phim' => 10, 'id_the_loai' => 2],
            ['id_phim' => 10, 'id_the_loai' => 8],

            // Phim 11
            ['id_phim' => 11, 'id_the_loai' => 3],
            ['id_phim' => 11, 'id_the_loai' => 5],

            // Phim 12
            ['id_phim' => 12, 'id_the_loai' => 6],
            ['id_phim' => 12, 'id_the_loai' => 7],

            // Phim 13
            ['id_phim' => 13, 'id_the_loai' => 4],
            ['id_phim' => 13, 'id_the_loai' => 10],

            // Phim 14
            ['id_phim' => 14, 'id_the_loai' => 5],
            ['id_phim' => 14, 'id_the_loai' => 8],

            // Phim 15
            ['id_phim' => 15, 'id_the_loai' => 2],
            ['id_phim' => 15, 'id_the_loai' => 9],

            // Phim 16
            ['id_phim' => 16, 'id_the_loai' => 3],
            ['id_phim' => 16, 'id_the_loai' => 6],
        ]);
    }
}
