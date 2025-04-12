<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DichVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dich_vus')->delete();
        DB::table('dich_vus')->truncate();
        DB::table('dich_vus')->insert([
            [
                'ten_dich_vu' => 'Ghế + Popcorn + Nước',
                'gia_tien' => 50000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/6be57469a6b642ceaa934a99fe5d6e76.png' // 1: Còn hoạt động
            ],
            [
                'ten_dich_vu' => 'Ghế đôi + Popcorn + Nước',
                'gia_tien' => 250000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/73f3bb767616493f8b4631522186c2b4.png'
            ],
            [
                'ten_dich_vu' => 'Ghế Vip + Popcorn + Nước',
                'gia_tien' => 350000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/945c9ba18e814a9db3a5af2ce7abe6ac.png'
            ],
            [
                'ten_dich_vu' => 'Ghế vip + Popcorn + Nước',
                'gia_tien' => 450000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/7c30c81a75484a11bb9d50b176e3b474.png'
            ],
            [
                'ten_dich_vu' => 'Ghế + combo Popcorn + Nước',
                'gia_tien' => 1550000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/cefd37aa5a204def893e5f37683aa0c7.png'
            ],
            [
                'ten_dich_vu' => 'Ghế + Popcorn + Nước',
                'gia_tien' => 50000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/6be57469a6b642ceaa934a99fe5d6e76.png' // 1: Còn hoạt động
            ],
            [
                'ten_dich_vu' => 'Ghế đôi + Popcorn + Nước',
                'gia_tien' => 250000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/73f3bb767616493f8b4631522186c2b4.png'
            ],
            [
                'ten_dich_vu' => 'Ghế Vip + Popcorn + Nước',
                'gia_tien' => 350000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/945c9ba18e814a9db3a5af2ce7abe6ac.png'
            ],
            [
                'ten_dich_vu' => 'Ghế vip + Popcorn + Nước',
                'gia_tien' => 450000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/7c30c81a75484a11bb9d50b176e3b474.png'
            ],
            [
                'ten_dich_vu' => 'Ghế + combo Popcorn + Nước',
                'gia_tien' => 1550000,
                'tinh_trang' => 1,
                'hinh_anh'=>'https://media.lottecinemavn.com/Media/WebAdmin/cefd37aa5a204def893e5f37683aa0c7.png'
            ]
        ]);
    }
}
