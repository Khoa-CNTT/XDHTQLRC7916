<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nhan_viens')->delete();
        DB::table('nhan_viens')->truncate();
        DB::table('nhan_viens')->insert([
            [
                'ten_nhan_vien' => 'Admin',
                'email' => 'admin@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ngay_sinh' => '1990-01-01 00:00:00',
                'sdt' => '0123456789',
                'ngay_bat_dau' => '2024-01-01 00:00:00',
                'id_chuc_vu' => '1',
                'avatar' => 'https://th.bing.com/th/id/OIP.0wbWgY5a9z4hPB3chYj7VQHaHY?rs=1&pid=ImgDetMain',
                'tinh_trang' => 1,
                'is_master' => 0,
            ],
            [
                'ten_nhan_vien' => 'Trần Văn Duyệt',
                'email' => 'duyetvan03@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ngay_sinh' => '1990-01-01 00:00:00',
                'sdt' => '0123456789',
                'ngay_bat_dau' => '2024-01-01 00:00:00',
                'id_chuc_vu' => '2',
                'avatar' => 'https://th.bing.com/th/id/OIP.0wbWgY5a9z4hPB3chYj7VQHaHY?rs=1&pid=ImgDetMain',
                'tinh_trang' => 1,
                'is_master' => 0,
            ],
            [
                'ten_nhan_vien' => 'Đỗ Văn Đại',
                'email' => 'dovandai2905@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ngay_sinh' => '1990-01-01 00:00:00',
                'sdt' => '03357287014',
                'ngay_bat_dau' => '2024-01-01 00:00:00',
                'id_chuc_vu' => '3',
                'avatar' => 'https://th.bing.com/th/id/OIP.0wbWgY5a9z4hPB3chYj7VQHaHY?rs=1&pid=ImgDetMain',
                'tinh_trang' => 1,
                'is_master' => 0,
            ],
            [
                'ten_nhan_vien' => 'Hồ Minh Tùng',
                'email' => 'tungho.ntt@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ngay_sinh' => '1990-01-01 00:00:00',
                'sdt' => '0935303721',
                'ngay_bat_dau' => '2024-01-01 00:00:00',
                'id_chuc_vu' => '4',
                'avatar' => 'https://th.bing.com/th/id/OIP.0wbWgY5a9z4hPB3chYj7VQHaHY?rs=1&pid=ImgDetMain',
                'tinh_trang' => 1,
                'is_master' => 0,
            ],
            [
                'ten_nhan_vien' => 'Nguyễn Quang Hùng',
                'email' => 'hung.ntt@gmail.com',
                'password'          =>  bcrypt('123456'),
                'ngay_sinh' => '1990-01-01 00:00:00',
                'sdt' => '0935303321',
                'ngay_bat_dau' => '2024-01-01 00:00:00',
                'id_chuc_vu' => '5',
                'avatar' => 'https://th.bing.com/th/id/OIP.0wbWgY5a9z4hPB3chYj7VQHaHY?rs=1&pid=ImgDetMain',
                'tinh_trang' => 1,
                'is_master' => 0,
            ],

        ]);
    }
}
