<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //ALTER TABLE
    public function up(): void
    {
        Schema::table('chi_tiet_ves', function (Blueprint $table) {
            $table->timestamp('thoi_gian_check_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chi_tiet_ves', function (Blueprint $table) {
            $table->dropColumn('thoi_gian_check_in');
        });
    }
};
