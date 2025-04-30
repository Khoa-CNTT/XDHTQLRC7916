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
        Schema::create('chi_tiet_ve_dich_vus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_chi_tiet_ve')->nullable()->constrained('chi_tiet_ves')->onDelete('cascade');
            $table->foreignId('id_dich_vu')->nullable()->constrained('dich_vus')->onDelete('cascade');
            $table->integer('so_luong')->default(0); // Số lượng dịch vụ được chọn
            $table->decimal('gia_tien', 10, 2); // Giá tiền của dịch vụ tại thời điểm mua
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_ve_dich_vus');
    }
};
