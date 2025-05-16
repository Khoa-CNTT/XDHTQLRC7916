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
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nhan_vien');
            $table->datetime('ngay_sinh');
            $table->string('sdt');
            $table->string('email');
            $table->string('password');
            $table->datetime('ngay_bat_dau');
            $table->string('id_chuc_vu');
            $table->string('avatar');
            $table->integer('tinh_trang');
            $table->string('is_master')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
