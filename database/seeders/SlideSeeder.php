<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('slides')->delete();
        DB::table('slides')->truncate();
        DB::table('slides')->insert([
            [
                'link_hinh_anh' => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745073231/1440x548_c7ead1055e_q7eabi.jpg',
                'tinh_trang' => 1,
            ],
            [
                'link_hinh_anh' => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745072904/eeb56db285a145c894c6c9d090d43376_bxxxnl.jpg',
                'tinh_trang' => 1,
            ],
            [
                'link_hinh_anh' => 'https://res.cloudinary.com/dfff9gqxw/image/upload/v1745073328/f3c79fb3147a4060af45dbf5dd4022bb_vuvnzh.jpg',
                'tinh_trang' => 1,
            ],
        ]);
    }
}
