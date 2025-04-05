<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quan_ly_phims', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phim');
            $table->date('ngay_chieu');
            $table->integer('thoi_luong');
            $table->string('slug_phim');
            $table->string('dao_dien');
            $table->string('hinh_anh');
            $table->text('trailer_ytb');
            $table->string('dien_vien');
            $table->string('nha_san_xuat');
            $table->unsignedBigInteger('id_the_loai'); // Đảm bảo kiểu dữ liệu khớp với id của bảng the_loais
            $table->string('gioi_han_do_tuoi');
            $table->text('mo_ta');
            $table->string('danh_gia');
            $table->integer('tinh_trang')->default(1);
            $table->timestamps();

            $table->foreign('id_the_loai')
                ->references('id')
                ->on('the_loais')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quan_ly_phims');
    }
};
