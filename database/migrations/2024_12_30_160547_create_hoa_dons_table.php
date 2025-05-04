<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hoa_don')->unique();
            $table->foreignId('id_khach_hang')->constrained('khach_hangs');
            $table->foreignId('id_suat')->constrained('suat_chieus');
            $table->decimal('tong_tien', 10, 0);
            $table->string('phuong_thuc_thanh_toan')->nullable();
            $table->tinyInteger('trang_thai')->default(0); // 0: Chờ thanh toán, 1: Đã thanh toán, 2: Đã hủy
            $table->timestamp('ngay_thanh_toan')->nullable();
            $table->string('ma_qr_checkin')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
