<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_the_loais', function (Blueprint $table) {
            // Cột auto_increment id
            $table->id();

            // Cột ngoại khóa
            $table->unsignedBigInteger('id_phim');
            $table->unsignedBigInteger('id_the_loai');

            // Cột timestamps
            $table->timestamps();

            // Thêm foreign key
            $table->foreign('id_phim')->references('id')->on('quan_ly_phims')->onDelete('cascade');
            $table->foreign('id_the_loai')->references('id')->on('the_loais')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_the_loais');
    }
};
