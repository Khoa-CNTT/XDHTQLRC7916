<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucNangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chuc_nangs')->delete();

        DB::table('chuc_nangs')->truncate();

        DB::table('chuc_nangs')->insert([

                // Loại phòng
                ["id" => 1, "ten_chuc_nang" => "Xem Thông Tin Loại Phòng"],
                ["id" => 2, "ten_chuc_nang" => "Tạo Mới Loại Phòng"],
                ["id" => 3, "ten_chuc_nang" => "Tìm Kiếm Loại Phòng"],
                ["id" => 4, "ten_chuc_nang" => "Xóa Loại Phòng"],
                ["id" => 61, "ten_chuc_nang" => "Cập Nhật Loại Phòng"],

                // Khách hàng
                ["id" => 5, "ten_chuc_nang" => "Xem Thông Tin Khách Hàng"],
                ["id" => 6, "ten_chuc_nang" => "Tạo Mới Khách Hàng"],
                //["id" => 7, "ten_chuc_nang" => "Tìm Kiếm Khách Hàng"], //kh co
                ["id" => 8, "ten_chuc_nang" => "Xóa Khách Hàng"],
                ["id" => 9, "ten_chuc_nang" => "Đổi Trạng Thái Khách Hàng"],
                ["id" => 62, "ten_chuc_nang" => "Cập Nhật Khách Hàng"],

                // Nhân viên
                ["id" => 10, "ten_chuc_nang" => "Xem Thông Tin Nhân Viên"],
                ["id" => 11, "ten_chuc_nang" => "Tạo Mới Nhân Viên"],
                //["id" => 12, "ten_chuc_nang" => "Tìm Kiếm Nhân Viên"], //khong co
                ["id" => 13, "ten_chuc_nang" => "Xóa Nhân Viên"],
                ["id" => 14, "ten_chuc_nang" => "Đổi Trạng Thái Nhân Viên"],
                ["id" => 63, "ten_chuc_nang" => "Cập Nhật Nhân Viên"],

                // Dịch vụ
                ["id" => 15, "ten_chuc_nang" => "Xem Thông Tin Dịch Vụ"],
                ["id" => 16, "ten_chuc_nang" => "Tạo Mới Dịch Vụ"],
                ["id" => 17, "ten_chuc_nang" => "Tìm Kiếm Dịch Vụ"],
                ["id" => 18, "ten_chuc_nang" => "Xóa Dịch Vụ"],
                ["id" => 19, "ten_chuc_nang" => "Đổi Trạng Thái Dịch Vụ"],
                ["id" => 64, "ten_chuc_nang" => "Cập Nhật Dịch Vụ"],

                // Đánh giá
                ["id" => 20, "ten_chuc_nang" => "Xem Thông Tin Đánh Giá"],
                ["id" => 21, "ten_chuc_nang" => "Tạo Mới Đánh Giá"],
                ["id" => 22, "ten_chuc_nang" => "Tìm Kiếm Đánh Giá"],
                ["id" => 23, "ten_chuc_nang" => "Xóa Đánh Giá"],
                ["id" => 24, "ten_chuc_nang" => "Đổi Trạng Thái Đánh Giá"],
                ["id" => 65, "ten_chuc_nang" => "Cập Nhật Đánh Giá"],

                // Chức vụ
                ["id" => 25, "ten_chuc_nang" => "Xem Thông Tin Chức Vụ"],
                ["id" => 26, "ten_chuc_nang" => "Tạo Mới Chức Vụ"],
                ["id" => 28, "ten_chuc_nang" => "Xóa Chức Vụ"],
                ["id" => 29, "ten_chuc_nang" => "Đổi Trạng Thái Chức Vụ"],
                ["id" => 60, "ten_chuc_nang" => "Đổi Trạng Thái Master Cho Chức Vụ"],
                ["id" => 66, "ten_chuc_nang" => "Cập Nhật Chức Vụ"],

                // Ghế
                ["id" => 30, "ten_chuc_nang" => "Xem Thông Tin Ghế"],
                ["id" => 31, "ten_chuc_nang" => "Tạo Mới Ghế"],
                //["id" => 32, "ten_chuc_nang" => "Tìm Kiếm Ghế"], //Không có
                ["id" => 33, "ten_chuc_nang" => "Xóa Ghế"],
                ["id" => 34, "ten_chuc_nang" => "Đổi Trạng Thái Ghế"],
                ["id" => 35, "ten_chuc_nang" => "Đổi Loại Ghế"],
                ["id" => 67, "ten_chuc_nang" => "Cập Nhật Ghế"],

                // Vé
                ["id" => 36, "ten_chuc_nang" => "Xem Thông Tin Vé"], //check lại

                // Suất chiếu
                ["id" => 40, "ten_chuc_nang" => "Xem Thông Tin Suất Chiếu"],
                ["id" => 41, "ten_chuc_nang" => "Tạo Mới Suất Chiếu"], //không hiểu
                ["id" => 42, "ten_chuc_nang" => "Tìm Kiếm Suất Chiếu"],//không có
                ["id" => 43, "ten_chuc_nang" => "Xóa Suất Chiếu"],
                ["id" => 44, "ten_chuc_nang" => "Đổi Trạng Thái Suất Chiếu"],
                ["id" => 45, "ten_chuc_nang" => "Cập Nhật Trạng Thái Tự Động"], //không hiểu
                ["id" => 46, "ten_chuc_nang" => "Lấy Số Ghế Trống"], // không hiểu
                ["id" => 69, "ten_chuc_nang" => "Cập Nhật Suất Chiếu"],

                // Phòng
                ["id" => 47, "ten_chuc_nang" => "Xem Thông Tin Phòng"],
                ["id" => 48, "ten_chuc_nang" => "Tạo Mới Phòng"],
                ["id" => 49, "ten_chuc_nang" => "Tìm Kiếm Phòng"], //không có
                ["id" => 50, "ten_chuc_nang" => "Xóa Phòng"],
                ["id" => 51, "ten_chuc_nang" => "Đổi Trạng Thái Phòng"],
                ["id" => 70, "ten_chuc_nang" => "Cập Nhật Phòng"],

                // Chi tiết thể loại
                ["id" => 52, "ten_chuc_nang" => "Xem Thông Tin Chi Tiết Thể Loại"],
                ["id" => 53, "ten_chuc_nang" => "Tạo Mới Chi Tiết Thể Loại"],
                //["id" => 54, "ten_chuc_nang" => "Tìm Kiếm Chi Tiết Thể Loại"], //không có
                ["id" => 55, "ten_chuc_nang" => "Xóa Chi Tiết Thể Loại"],
                //["id" => 71, "ten_chuc_nang" => "Cập Nhật Chi Tiết Thể Loại"],//không có

                // Chi tiết vé
                //["id" => 56, "ten_chuc_nang" => "Xem Thông Tin Chi Tiết Vé"], //không hiểu
                //["id" => 57, "ten_chuc_nang" => "Tạo Mới Chi Tiết Vé"], // không hiểu
                //["id" => 58, "ten_chuc_nang" => "Tìm Kiếm Chi Tiết Vé"], //không có
                ["id" => 59, "ten_chuc_nang" => "Xóa Chi Tiết Vé"],
                ["id" => 72, "ten_chuc_nang" => "Cập Nhật Chi Tiết Vé"],

        ]);
    }
}
