<?php

namespace App\Http\Controllers;

use App\Models\ChiTietTheLoai;
use Illuminate\Http\Request;
use App\Models\QuanLyPhim;
use App\Models\TheLoai;

class TrangChuController extends Controller
{
    public function dataTrangChu(Request $request)
    {
        $date = $request->date;

        $listPhim = QuanLyPhim::with('theLoais')
            ->where('ngay_chieu', '<=', $date)
            ->get();

        return response()->json([
            'listPhim' => $listPhim,
        ]);
    }

    public function dataPhimSapChieu(Request $request)
    {
        $date = $request->date;
        $listPhim = QuanLyPhim::with('theLoais')
            ->where('ngay_chieu', '>', $date)
            ->get();

        return response()->json([
            'data'             => $listPhim,
        ]);
    }
}
