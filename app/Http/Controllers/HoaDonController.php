<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\ChiTietVe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HoaDonController extends Controller
{
    public function getData()
    {
        $data = HoaDon::leftJoin('nhan_viens', 'hoa_dons.id_nhan_vien', 'nhan_viens.id')
            ->leftJoin('khach_hangs', 'hoa_dons.id_khach_hang', 'khach_hangs.id')
            ->leftJoin('suat_chieus', 'hoa_dons.id_suat', 'suat_chieus.id')

            ->leftJoin('quan_ly_phims', 'suat_chieus.phim_id', 'quan_ly_phims.id') // Sửa lại id_phim thành phim_id
            ->select(
                'hoa_dons.*',
                'nhan_viens.ten_nhan_vien',
                'khach_hangs.ten_khach_hang',
                'quan_ly_phims.ten_phim',
                'suat_chieus.gio_bat_dau',
                'suat_chieus.ngay_chieu',
                'suat_chieus.dinh_dang',
                'suat_chieus.ngon_ngu'
            )
            ->orderBy('hoa_dons.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'hoa_don' => $data
        ]);
    }
    public function getDataClient()
    {
        $data = HoaDon::join('khach_hangs', 'hoa_dons.id_khach_hang', 'khach_hangs.id')
            ->join('suat_chieus', 'hoa_dons.id_suat', 'suat_chieus.id')
            ->join('quan_ly_phims', 'suat_chieus.phim_id', 'quan_ly_phims.id') // Sửa lại id_phim thành phim_id
            ->where('hoa_dons.trang_thai', 1)
            ->select(
                'hoa_dons.*',
                'khach_hangs.ten_khach_hang',
                'quan_ly_phims.ten_phim',
                'suat_chieus.gio_bat_dau',
                'suat_chieus.ngay_chieu',
                'suat_chieus.dinh_dang',
                'suat_chieus.ngon_ngu'
            )
            ->orderBy('hoa_dons.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'hoa_don' => $data
        ]);
    }

    public function chiTietDatVe(Request $request)
    {
        try {
            $data = ChiTietVe::where('id_hoa_don', $request->id)
                ->join('ghes', 'chi_tiet_ves.id_ghe', '=', 'ghes.id')
                ->join('suat_chieus', 'chi_tiet_ves.id_suat', '=', 'suat_chieus.id')
                ->join('phongs', 'suat_chieus.phong_id', '=', 'phongs.id')
                ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id') // Sửa lại id_phim thành phim_id
                ->join('khach_hangs', 'chi_tiet_ves.id_khach_hang', '=', 'khach_hangs.id')
                ->select(
                    'ghes.ten_ghe',
                    'quan_ly_phims.ten_phim',
                    'suat_chieus.gio_bat_dau',
                    'suat_chieus.ngay_chieu',
                    'suat_chieus.dinh_dang',
                    'suat_chieus.ngon_ngu',
                    'phongs.ten_phong',
                    'khach_hangs.ten_khach_hang'
                )
                ->get();

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
