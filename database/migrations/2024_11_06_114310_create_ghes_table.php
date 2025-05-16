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
        Schema::create('ghes', function (Blueprint $table) {
            $table->id();
            $table->string('ten_ghe');
            $table->foreignId('phong_id')->constrained('phongs')->onDelete('cascade');
            $table->integer('hang')->nullable(); // Thêm trường hàng (A, B, C...)
            $table->integer('cot')->nullable(); // Thêm trường cột (1, 2, 3...)
            $table->tinyInteger('loai_ghe')->default(0); // 0: Thường, 1: VIP
            $table->tinyInteger('trang_thai')->default(1); // 0: Không hoạt động, 1: Hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ghes');
    }
};
