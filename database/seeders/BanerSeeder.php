<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BanerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('baners')->delete();
        DB::table('baners')->truncate();
        DB::table('baners')->insert([
            [
                'id_phim' => '1',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100002.jpg',
                'tinh_trang' => 1,
            ],
            [
                'id_phim' => '1',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100003.jpg',
                'tinh_trang' => 0,
            ],
            [
                'id_phim' => '1',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100004.jpg',
                'tinh_trang' => 0,
            ],

            //
            [
                'id_phim' => '2',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100005.jpg',
                'tinh_trang' => 1,
            ],
            [
                'id_phim' => '2',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100006.jpg',
                'tinh_trang' => 0,
            ],
            [
                'id_phim' => '2',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11597_105_100002.jpg',
                'tinh_trang' => 0,
            ],
            //

            [
                'id_phim' => '3',
                'hinh_anh' => 'https://cdn.galaxycine.vn/media/2024/11/14/linh-mieu-1_1731569919178.jpg',
                'tinh_trang' => 1,
            ],
            [
                'id_phim' => '3',
                'hinh_anh' => 'https://cdn.galaxycine.vn/media/2024/11/12/cuoi-xuyen-bien-gioi-2048_1731395977602.jpg',
                'tinh_trang' => 0,
            ],
            [
                'id_phim' => '3',
                'hinh_anh' => 'https://cdn.galaxycine.vn/media/2024/11/6/gladiator-2048_1730878996598.jpg',
                'tinh_trang' => 0,
            ],

        ]);
    }
}
