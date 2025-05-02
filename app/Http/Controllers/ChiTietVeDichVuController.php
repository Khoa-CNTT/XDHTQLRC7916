<?php

namespace App\Http\Controllers;

use App\Models\ChiTietVe;
use App\Models\DichVu;
use App\Models\ChiTietVeDichVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChiTietVeDichVuController extends Controller
{
    public function datDichVu(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Find all tickets for the current user and show
        $dsVe = ChiTietVe::where('id_suat', $request->id_suat)
            ->where('id_khach_hang', $user->id)
            ->where('tinh_trang', 1)
            ->get();

        if ($dsVe->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy vé cho suất chiếu này!"
            ]);
        }

        // Get the service details
        $dichVu = DichVu::find($request->id_dich_vu);
        if (!$dichVu) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy dịch vụ này!"
            ]);
        }

        // Check if service already exists for any of these tickets
        $chiTietVeDichVu = ChiTietVeDichVu::whereIn('id_chi_tiet_ve', $dsVe->pluck('id'))
            ->where('id_dich_vu', $request->id_dich_vu)
            ->first();

        if ($chiTietVeDichVu) {
            // If exists, increase quantity
            $chiTietVeDichVu->so_luong += 1;
            $chiTietVeDichVu->gia_tien = $dichVu->gia_tien * $chiTietVeDichVu->so_luong;
            $chiTietVeDichVu->save();

            // Make sure all tickets point to this service
            foreach($dsVe as $ve) {
                $ve->id_chi_tiet_ve_dich_vu = $chiTietVeDichVu->id;
                $ve->save();
            }

            return response()->json([
                'status' => true,
                'message' => "Đã tăng số lượng dịch vụ thành công!",
                'so_luong' => $chiTietVeDichVu->so_luong,
                'gia_tien' => $chiTietVeDichVu->gia_tien
            ]);
        } else {
            // Create new service ticket detail for the first ticket
            $chiTietVeDichVu = ChiTietVeDichVu::create([
                'id_chi_tiet_ve' => $dsVe->first()->id,
                'id_dich_vu' => $request->id_dich_vu,
                'so_luong' => 1,
                'gia_tien' => $dichVu->gia_tien
            ]);

            // Update all tickets with the same service detail ID
            foreach($dsVe as $ve) {
                $ve->id_chi_tiet_ve_dich_vu = $chiTietVeDichVu->id;
                $ve->save();
            }

            return response()->json([
                'status' => true,
                'message' => "Đã đặt dịch vụ thành công!",
                'so_luong' => $chiTietVeDichVu->so_luong,
                'gia_tien' => $chiTietVeDichVu->gia_tien
            ]);
        }
    }

    public function huyDichVu(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Find all tickets for the current user and show
        $dsVe = ChiTietVe::where('id_suat', $request->id_suat)
            ->where('id_khach_hang', $user->id)
            ->where('tinh_trang', 1)
            ->get();

        if ($dsVe->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy vé cho suất chiếu này!"
            ]);
        }

        foreach($dsVe as $ve) {
            // Find and delete the service ticket detail
            ChiTietVeDichVu::where('id_chi_tiet_ve', $ve->id)
                ->where('id_dich_vu', $request->id_dich_vu)
                ->delete();

            // Reset the service detail ID in the ticket
            $ve->id_chi_tiet_ve_dich_vu = null;
            $ve->save();
        }

        return response()->json([
            'status' => true,
            'message' => "Đã hủy dịch vụ thành công!"
        ]);
    }

    public function tangDichVu(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Find the service ticket detail
        $chiTietVeDichVu = ChiTietVeDichVu::whereHas('chiTietVe', function($query) use ($user, $request) {
            $query->where('id_suat', $request->id_suat)
                  ->where('id_khach_hang', $user->id)
                  ->where('tinh_trang', 1);
        })->where('id_dich_vu', $request->id_dich_vu)
          ->first();

        if (!$chiTietVeDichVu) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy dịch vụ này trong vé!"
            ]);
        }

        // Get the service details for price
        $dichVu = DichVu::find($request->id_dich_vu);

        // Increase quantity and update price
        $chiTietVeDichVu->so_luong += 1;
        $chiTietVeDichVu->gia_tien = $dichVu->gia_tien * $chiTietVeDichVu->so_luong;
        $chiTietVeDichVu->save();

        return response()->json([
            'status' => true,
            'message' => "Đã tăng số lượng dịch vụ thành công!",
            'so_luong' => $chiTietVeDichVu->so_luong,
            'gia_tien' => $chiTietVeDichVu->gia_tien
        ]);
    }

    public function giamDichVu(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Find the service ticket detail
        $chiTietVeDichVu = ChiTietVeDichVu::whereHas('chiTietVe', function($query) use ($user, $request) {
            $query->where('id_suat', $request->id_suat)
                  ->where('id_khach_hang', $user->id)
                  ->where('tinh_trang', 1);
        })->where('id_dich_vu', $request->id_dich_vu)
          ->first();

        if (!$chiTietVeDichVu) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy dịch vụ này trong vé!"
            ]);
        }

        if ($chiTietVeDichVu->so_luong <= 1) {
            return response()->json([
                'status' => false,
                'message' => "Số lượng dịch vụ không thể giảm thêm!"
            ]);
        }

        // Get the service details for price
        $dichVu = DichVu::find($request->id_dich_vu);

        // Decrease quantity and update price
        $chiTietVeDichVu->so_luong -= 1;
        $chiTietVeDichVu->gia_tien = $dichVu->gia_tien * $chiTietVeDichVu->so_luong;
        $chiTietVeDichVu->save();

        return response()->json([
            'status' => true,
            'message' => "Đã giảm số lượng dịch vụ thành công!",
            'so_luong' => $chiTietVeDichVu->so_luong,
            'gia_tien' => $chiTietVeDichVu->gia_tien
        ]);
    }

    public function getDanhSachDichVu(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Get list of services for the specified show
        $danhSachDichVu = ChiTietVeDichVu::join('chi_tiet_ves', 'chi_tiet_ve_dich_vus.id_chi_tiet_ve', '=', 'chi_tiet_ves.id')
            ->join('dich_vus', 'chi_tiet_ve_dich_vus.id_dich_vu', '=', 'dich_vus.id')
            ->where('chi_tiet_ves.id_suat', $request->id_suat)
            ->where('chi_tiet_ves.id_khach_hang', $user->id)
            ->where('chi_tiet_ves.tinh_trang', 1)
            ->select(
                'chi_tiet_ve_dich_vus.id',
                'chi_tiet_ve_dich_vus.id_dich_vu',
                'dich_vus.ten_dich_vu',
                'dich_vus.hinh_anh',
                'chi_tiet_ve_dich_vus.so_luong',
                'chi_tiet_ve_dich_vus.gia_tien',
                DB::raw('COUNT(chi_tiet_ves.id) as so_luong_ve')
            )
            ->groupBy(
                'chi_tiet_ve_dich_vus.id',
                'chi_tiet_ve_dich_vus.id_dich_vu',
                'dich_vus.ten_dich_vu',
                'dich_vus.hinh_anh',
                'chi_tiet_ve_dich_vus.so_luong',
                'chi_tiet_ve_dich_vus.gia_tien'
            )
            ->get();

        // Calculate total amount
        $tongTien = $danhSachDichVu->sum('gia_tien');

        return response()->json([
            'status' => true,
            'data' => $danhSachDichVu,
            'tong_tien_dich_vu' => $tongTien
        ]);
    }

    public function getDanhSachDichVuTheoVe(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // Validate if the ticket belongs to the user
        $ve = ChiTietVe::where('id', $request->id_chi_tiet_ve)
            ->where('id_khach_hang', $user->id)
            ->where('tinh_trang', 1)
            ->first();

        if (!$ve) {
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy vé này!"
            ]);
        }

        // Get services for specific ticket
        $danhSachDichVu = ChiTietVeDichVu::join('dich_vus', 'chi_tiet_ve_dich_vus.id_dich_vu', '=', 'dich_vus.id')
            ->where('chi_tiet_ve_dich_vus.id_chi_tiet_ve', $request->id_chi_tiet_ve)
            ->select(
                'chi_tiet_ve_dich_vus.id',
                'chi_tiet_ve_dich_vus.id_dich_vu',
                'dich_vus.ten_dich_vu',
                'dich_vus.hinh_anh',
                'chi_tiet_ve_dich_vus.so_luong',
                'chi_tiet_ve_dich_vus.gia_tien'
            )
            ->get();

        // Calculate total amount for this ticket
        $tongTien = $danhSachDichVu->sum('gia_tien');

        return response()->json([
            'status' => true,
            'data' => $danhSachDichVu,
            'tong_tien_dich_vu' => $tongTien
        ]);
    }
}

