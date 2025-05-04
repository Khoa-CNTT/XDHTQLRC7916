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
        Schema::create('chi_tiet_ves', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại đến bảng suat_chieus
            $table->foreignId('id_suat')->constrained('suat_chieus')->onDelete('cascade');

            // Khóa ngoại đến bảng ghes
            $table->foreignId('id_ghe')->constrained('ghes')->onDelete('cascade');

            // Giá tiền của vé
            $table->decimal('gia_tien', 10, 0)->default(0);

            // Khóa ngoại đến bảng hoa_dons (nullable vì chưa thanh toán)
            $table->foreignId('id_hoa_don')->nullable()->constrained('hoa_dons')->nullOnDelete();

            // Khóa ngoại đến bảng khach_hangs (nullable vì ghế có thể chưa được đặt)
            $table->foreignId('id_khach_hang')->nullable()->constrained('khach_hangs')->nullOnDelete();
            $table->string('ma_check')->nullable();
            $table->string('id_nhan_vien')->nullable();
            // Khóa ngoại đến bảng chi_tiet_ve_dich_vus (nullable vì ghế có thể chưa được đặt)
            $table->string('id_chi_tiet_ve_dich_vu')->nullable();

            // Trạng thái ghế (0: Còn trống, 1: Đã đặt, 2: Đang tạm giữ)
            $table->tinyInteger('tinh_trang')->default(0);
            // Trạng thái đã check in (0: Chưa check in, 1: Đã check in)
            $table->tinyInteger('checked_in')->default(0);

            // Thời gian đặt và hết hạn (cho tính năng tạm giữ ghế)
            $table->timestamp('thoi_gian_dat')->nullable();
            $table->timestamp('thoi_gian_het_han')->nullable();

            // Ghi chú
            $table->text('ghi_chu')->nullable();

            $table->timestamps();

            // Thêm unique constraint để đảm bảo mỗi ghế chỉ xuất hiện một lần trong mỗi suất chiếu
            $table->unique(['id_suat', 'id_ghe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_ves');
    }
};
