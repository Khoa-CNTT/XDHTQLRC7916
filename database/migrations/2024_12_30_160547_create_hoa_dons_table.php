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
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();

            // Mã hóa đơn (duy nhất)
            $table->string('ma_hoa_don')->unique();

            // Khóa ngoại đến bảng khach_hangs
            $table->foreignId('id_khach_hang')->constrained('khach_hangs')->onDelete('cascade');

            // Tổng tiền của hóa đơn
            $table->decimal('tong_tien', 10, 0)->default(0);

            // Phương thức thanh toán (tiền mặt, chuyển khoản, ví điện tử)
            $table->string('phuong_thuc_thanh_toan')->nullable();

            // Trạng thái hóa đơn (0: Chờ thanh toán, 1: Đã thanh toán, 2: Đã hủy)
            $table->tinyInteger('trang_thai')->default(0);

            // Thời gian thanh toán
            $table->timestamp('ngay_thanh_toan')->nullable();

            // Ghi chú
            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
