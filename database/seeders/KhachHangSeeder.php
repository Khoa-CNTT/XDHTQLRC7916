<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhachHangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('khach_hangs')->delete();
        // DB::table('khach_hangs')->truncate();
        DB::table('khach_hangs')->insert([
            [
                'ten_khach_hang'    => 'Hồ Minh Tùng',
                'email'             => 'tungho.mth@gmail.com',
                'so_dien_thoai'     => '0935303721',
                'password'          =>  bcrypt('123456'),
                're_password'          =>  bcrypt('123456'),
                'is_active' => 1,
                'ngay_sinh'     =>  '2005-01-01',
            ],
            [
                'ten_khach_hang' => 'Đỗ Văn Đại',
                'email' => 'dovandai2905@gmail.com',
                'so_dien_thoai' => '0935303721',
                'password'          =>  bcrypt('123456'),
                're_password'          =>  bcrypt('123456'),
                'is_active' => 1,
                'ngay_sinh'     =>  '2005-01-01',
            ],
            [
                'ten_khach_hang' => 'Trần Văn Duyệt',
                'email' => 'duyetvan03@gmail.com',
                'so_dien_thoai' => '0332162386',
                'password'          =>  bcrypt('123456'),
                're_password'          =>  bcrypt('123456'),
                'is_active' => 1,
                'ngay_sinh'     =>  '2005-01-01',
            ]
        ]);
    }
}
