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
        Schema::create('su_kiens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_su_kien');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->text('mo_ta');
            $table->integer('tinh_trang');
            $table->string('hinh_anh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('su_kiens');
    }
};
