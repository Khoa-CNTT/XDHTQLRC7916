<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\HoaDon;
use App\Models\ChiTietVe;
use App\Models\ChucVu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HoaDonController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 82;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
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
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
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
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
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

    public function quyen()
    {
        $id_chuc_nang = 81;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                return response()->json([
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }
        }
    }

    public function chiTietDatVe(Request $request)
    {
        try {
            $admin = Auth::guard('sanctum')->user();

            // Lấy tất cả chi tiết vé theo hóa đơn
            $query = ChiTietVe::where('id_hoa_don', $request->id)
                ->join('ghes', 'chi_tiet_ves.id_ghe', '=', 'ghes.id')
                ->join('suat_chieus', 'chi_tiet_ves.id_suat', '=', 'suat_chieus.id')
                ->join('phongs', 'suat_chieus.phong_id', '=', 'phongs.id')
                ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id')
                ->join('hoa_dons', 'chi_tiet_ves.id_hoa_don', '=', 'hoa_dons.id')
                ->leftJoin('chi_tiet_ve_dich_vus', 'chi_tiet_ves.id', '=', 'chi_tiet_ve_dich_vus.id_chi_tiet_ve')
                ->leftJoin('dich_vus', 'chi_tiet_ve_dich_vus.id_dich_vu', '=', 'dich_vus.id')
                ->select(
                    'chi_tiet_ves.id as id_chi_tiet_ve',
                    'ghes.ten_ghe',
                    'ghes.id as id_ghe',
                    'quan_ly_phims.ten_phim',
                    'suat_chieus.gio_bat_dau',
                    'suat_chieus.ngay_chieu',
                    'suat_chieus.dinh_dang',
                    'suat_chieus.ngon_ngu',
                    'phongs.ten_phong',
                    'hoa_dons.ma_qr_checkin',
                    'hoa_dons.ma_hoa_don',
                    'hoa_dons.tong_tien',
                    DB::raw('COALESCE(chi_tiet_ve_dich_vus.so_luong, 0) AS so_luong_dich_vu'),
                    'dich_vus.ten_dich_vu'
                );

            // Nếu là admin, lấy tên nhân viên; ngược lại lấy tên khách hàng
            if ($admin) {
                $query->leftJoin('nhan_viens', 'chi_tiet_ves.id_nhan_vien', '=', 'nhan_viens.id')
                    ->addSelect('nhan_viens.ten_nhan_vien');
            } else {
                $query->leftJoin('khach_hangs', 'chi_tiet_ves.id_khach_hang', '=', 'khach_hangs.id')
                    ->addSelect('khach_hangs.ten_khach_hang');
            }

            $data = $query->get();

            // Group lại theo chi tiết vé nếu muốn gộp dịch vụ cho từng vé
            $grouped = $data->groupBy('id_chi_tiet_ve')->map(function ($items) {
                $first = $items->first();
                return [
                    'id_chi_tiet_ve' => $first->id_chi_tiet_ve,
                    'ten_ghe' => $first->ten_ghe,
                    'id_ghe' => $first->id_ghe,
                    'ten_phim' => $first->ten_phim,
                    'gio_bat_dau' => $first->gio_bat_dau,
                    'ngay_chieu' => $first->ngay_chieu,
                    'dinh_dang' => $first->dinh_dang,
                    'ngon_ngu' => $first->ngon_ngu,
                    'ten_phong' => $first->ten_phong,
                    'ma_qr_checkin' => $first->ma_qr_checkin,
                    'ma_hoa_don' => $first->ma_hoa_don,
                    'tong_tien' => $first->tong_tien,
                    'ten_khach_hang' => $first->ten_khach_hang ?? null,
                    'ten_nhan_vien' => $first->ten_nhan_vien ?? null,
                    'dich_vus' => $items->map(function ($item) {
                        return [
                            'ten_dich_vu' => $item->ten_dich_vu,
                            'so_luong' => $item->so_luong_dich_vu,
                        ];
                    })->filter(fn($dv) => $dv['ten_dich_vu'] !== null)->values()
                ];
            })->values();

            return response()->json([
                'status' => true,
                'data' => $grouped
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
