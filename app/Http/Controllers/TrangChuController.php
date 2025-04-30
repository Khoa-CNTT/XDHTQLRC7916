<?php

namespace App\Http\Controllers;

use App\Models\ChiTietTheLoai;
use Illuminate\Http\Request;
use App\Models\QuanLyPhim;
use App\Models\TheLoai;

class TrangChuController extends Controller
{
    public function dataTrangChu()
    {
        $listPhim = QuanLyPhim::leftjoin('the_loais', 'the_loais.id', 'quan_ly_phims.id_the_loai')
            ->select('quan_ly_phims.*','the_loais.ten_the_loai')
            ->get();

        return response()->json([
            'listPhim'             => $listPhim,
        ]);

    }
}