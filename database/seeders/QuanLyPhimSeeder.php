<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuanLyPhimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quan_ly_phims')->delete();
        // DB::table('quan_ly_phims')->truncate();
        DB::table('quan_ly_phims')->insert([
            [
                'ten_phim' => 'JUNG KOOK: I AM STILL',
                'slug_phim' => 'jung-kook-i-am-still',
                'ngay_chieu' => Carbon::parse('2024-01-01'),
                'thoi_luong' => '120',
                'dao_dien' => 'Đạo Diễn 1',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202409/11559_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/LWkh_hXeEeg?si=eUd_mxvnOCXi9T-G',
                'dien_vien' => 'Diễn Viên 1, Diễn Viên 2',
                'nha_san_xuat' => 'Nhà Sản Xuất 1',
                'id_the_loai' => '1',
                'gioi_han_do_tuoi' => '18+',
                'mo_ta' => 'Mô tả phim 1',
                'danh_gia' => '5/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Thêm 14 bản ghi khác với các giá trị tương ứng
            [
                'ten_phim' => 'TEE YOD: QUỶ ĂN TẠNG PHẦN 2',
                'slug_phim' => 'tee-yod-quy-an-tang-phan-2',
                'ngay_chieu' => Carbon::parse('2024-02-01'),
                'thoi_luong' => '90',
                'dao_dien' => 'Đạo Diễn 2',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11567_103_100006.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/wJO_vIDZn-I?si=uFRXvxKDYh9bxLmw',
                'dien_vien' => 'Diễn Viên 3, Diễn Viên 4',
                'nha_san_xuat' => 'Nhà Sản Xuất 2',
                'id_the_loai' => '2',
                'gioi_han_do_tuoi' => '16+',
                'mo_ta' => 'Mô tả phim 2',
                'danh_gia' => '4/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // ... tiếp tục thêm các bản ghi khác
            [
                'ten_phim' => 'ROBOT HOANG DÃ',
                'slug_phim' => 'robot-hoang-da',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11482_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/QT5j0Uf-rdM?si=UbvG5a-dbKxNS_E_',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lặp lại cho đến khi đủ 15 bản ghi
            [
                'ten_phim' => 'CÁM',
                'slug_phim' => 'cam',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202409/11507_103_100004.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/rbHUhCcSXEM?si=gb0k7EDOzombG-1V',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lặp lại cho đến khi đủ 15 bản ghi
            [
                'ten_phim' => 'FUBAO: BẢO BỐI CỦA ÔNG',
                'slug_phim' => 'fubao-bao-boi-cua-ong',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11574_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/erxeLAg85fg?si=txZXIotsKCYep884',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lặp lại cho đến khi đủ 15 bản ghi
            [
                'ten_phim' => 'BIỆT ĐỘI HOT GIRL',
                'slug_phim' => 'biet-doi-hot-girl',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11595_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/SjkcA2ZCmDU?si=LZGI2Hh0R3W3v_xq',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Lặp lại cho đến khi đủ 15 bản ghi
            [
                'ten_phim' => 'TRÒ CHƠI NHÂN TÍNH',
                'slug_phim' => 'tro-choi-nhan-tinh',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11592_103_100001.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/h0_kFeF__rc?si=0fZ44RWSmCS4yy-O',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ten_phim' => 'CÔ DÂU HÀO MÔN',
                'slug_phim' => 'co-dau-hao-mon',
                'ngay_chieu' => Carbon::parse('2024-03-01'),
                'thoi_luong' => '110',
                'dao_dien' => 'Đạo Diễn 3',
                'hinh_anh' => 'https://media.lottecinemavn.com/Media/MovieFile/MovieImg/202410/11556_103_100002.jpg',
                'trailer_ytb' => 'https://www.youtube.com/embed/IILf3ZEBnmM?si=oa9jD-RWhyleliWG',
                'dien_vien' => 'Diễn Viên 5, Diễn Viên 6',
                'nha_san_xuat' => 'Nhà Sản Xuất 3',
                'id_the_loai' => '3',
                'gioi_han_do_tuoi' => '13+',
                'mo_ta' => 'Mô tả phim 3',
                'danh_gia' => '3/5',
                'tinh_trang' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
