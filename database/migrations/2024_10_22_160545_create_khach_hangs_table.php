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
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khach_hang');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->string('password');
            $table->string('re_password');
            $table->string('hash_active')->nullable();
            $table->string('hash_reset')->nullable();
            $table->integer('is_block')->default(0);
            $table->integer('is_active')->default(0);
            $table->date('ngay_sinh')->nullable();
            $table->string('google_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hangs');
    }
};
