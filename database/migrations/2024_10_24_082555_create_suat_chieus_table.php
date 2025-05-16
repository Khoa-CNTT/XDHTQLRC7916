<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suat_chieus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phim_id')->constrained('quan_ly_phims')->onDelete('cascade');
            $table->foreignId('phong_id')->constrained('phongs')->onDelete('cascade');
            $table->date('ngay_chieu');
            $table->time('gio_bat_dau');
            $table->time('gio_ket_thuc');
            $table->decimal('gia_ve', 10, 2);
            $table->decimal('gia_ve_vip', 10, 2)->default(0);
            $table->decimal('gia_ve_doi', 10, 2)->default(0);
            $table->string('trang_thai')->default('Sắp chiếu'); // 'Sắp chiếu', 'Đang chiếu', 'Đã chiếu', 'Hết vé', 'Hủy'
            $table->string('dinh_dang')->default('2D'); // '2D', '3D', 'IMAX'
            $table->string('ngon_ngu')->default('Phụ đề'); // 'Phụ đề', 'Lồng tiếng', 'Nguyên bản'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suat_chieus');
    }
};
