<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DichVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('dich_vus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('dich_vus')->insert([
            [
                'ten_dich_vu' => 'Combo Popcorn + Nước (nhỏ)',
                'gia_tien' => 40000,
                'tinh_trang' => 1,
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/6be57469a6b642ceaa934a99fe5d6e76.png'
            ],
            [
                'ten_dich_vu' => 'Combo Popcorn + Nước (vừa)',
                'gia_tien' => 60000,
                'tinh_trang' => 1,
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/73f3bb767616493f8b4631522186c2b4.png'
            ],
            [
                'ten_dich_vu' => 'Combo Popcorn + Nước (lớn)',
                'gia_tien' => 80000,
                'tinh_trang' => 1,
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/945c9ba18e814a9db3a5af2ce7abe6ac.png'
            ],
            [
                'ten_dich_vu' => 'Combo Gia đình (2 bắp + 2 nước)',
                'gia_tien' => 150000,
                'tinh_trang' => 1,
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/7c30c81a75484a11bb9d50b176e3b474.png'
            ],
            [
                'ten_dich_vu' => 'Combo Party (4 bắp + 4 nước)',
                'gia_tien' => 280000,
                'tinh_trang' => 1,
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/cefd37aa5a204def893e5f37683aa0c7.png'
            ]
        ]);
    }
}
