<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('goc_dien_anhs', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('hinh_anh')->nullable();
            $table->date('ngay_dang');
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goc_dien_anhs');
    }
};
