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
                'link_hinh_anh' => 'https://media.lottecinemavn.com/Media/WebAdmin/d3c9eea3982c46a09c9d9073cb6d2c17.jpg',
                'tinh_trang' => 1,
            ],
            [
                'link_hinh_anh' => 'https://media.lottecinemavn.com/Media/Event/44d6f79e22974014b17275f0c6251372.jpg',
                'tinh_trang' => 1,
            ],
            [
                'link_hinh_anh' => 'https://dskb4mmeexzvj.cloudfront.net/cinema-shop/product-management/image/1440x548_c7ead1055e.jpg',
                'tinh_trang' => 1,
            ],
        ]);
    }
}
