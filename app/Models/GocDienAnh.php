<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GocDienAnh extends Model
{
    protected $table = 'goc_dien_anhs';
    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'hinh_anh',
        'ngay_dang',
        'trang_thai'
    ];

    // public function up(): void
    // {
    //     Schema::create('goc_dien_anhs', function (Blueprint $table) {
    //         $table->string('tieu_de');
    //         $table->text('noi_dung');
    //         $table->string('hinh_anh')->nullable();
    //         $table->date('ngay_dang');
    //         $table->boolean('trang_thai')->default(true);
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('goc_dien_anhs');
    // }
}
