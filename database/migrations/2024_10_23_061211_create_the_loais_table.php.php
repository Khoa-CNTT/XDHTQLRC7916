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
        Schema::create('the_loais', function (Blueprint $table) {
            $table->id();
            $table->string('ten_the_loai');
            $table->text('mo_ta')->nullable();
            $table->unsignedBigInteger('id_chi_tiet_the_loai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('the_loais');
    }
};
