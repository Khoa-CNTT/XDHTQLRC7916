<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function thongKeDoanhThu()
    {
        // Thống kê tổng doanh thu theo phương thức thanh toán
        $thongKeTheoPhuongThuc = HoaDon::where('trang_thai', 1)
            ->select('phuong_thuc_thanh_toan',
                    DB::raw('COUNT(*) as so_luong_hoa_don'),
                    DB::raw('SUM(tong_tien) as tong_doanh_thu'))
            ->groupBy('phuong_thuc_thanh_toan')
            ->get();

        // Tính tổng doanh thu của tất cả hóa đơn đã thanh toán
        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->sum('tong_tien');

        return response()->json([
            'thong_ke_theo_phuong_thuc' => $thongKeTheoPhuongThuc,
            'tong_doanh_thu' => $tongDoanhThu,
            'message' => 'Thống kê doanh thu thành công'
        ]);
    }

    public function thongKeTheoNgay(Request $request)
    {
        $ngay = $request->ngay ?? Carbon::now()->toDateString();

        $thongKe = HoaDon::where('trang_thai', 1)
            ->whereDate('ngay_thanh_toan', $ngay)
            ->select(
                'phuong_thuc_thanh_toan',
                DB::raw('COUNT(*) as so_luong_hoa_don'),
                DB::raw('SUM(tong_tien) as tong_doanh_thu')
            )
            ->groupBy('phuong_thuc_thanh_toan')
            ->get();

        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->whereDate('ngay_thanh_toan', $ngay)
            ->sum('tong_tien');

        return response()->json([
            'ngay' => $ngay,
            'thong_ke' => $thongKe,
            'tong_doanh_thu' => $tongDoanhThu
        ]);
    }

    public function thongKeTheoTuan(Request $request)
    {
        $tuan = $request->tuan ?? Carbon::now()->startOfWeek()->toDateString();
        $startOfWeek = Carbon::parse($tuan)->startOfWeek();
        $endOfWeek = Carbon::parse($tuan)->endOfWeek();

        $thongKe = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw('DATE(ngay_thanh_toan) as ngay'),
                'phuong_thuc_thanh_toan',
                DB::raw('COUNT(*) as so_luong_hoa_don'),
                DB::raw('SUM(tong_tien) as tong_doanh_thu')
            )
            ->groupBy('ngay', 'phuong_thuc_thanh_toan')
            ->orderBy('ngay')
            ->get();

        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfWeek, $endOfWeek])
            ->sum('tong_tien');

        return response()->json([
            'tu_ngay' => $startOfWeek->toDateString(),
            'den_ngay' => $endOfWeek->toDateString(),
            'thong_ke' => $thongKe,
            'tong_doanh_thu' => $tongDoanhThu
        ]);
    }

    public function thongKeTheoThang(Request $request)
    {
        $thang = $request->thang ?? Carbon::now()->format('Y-m');
        $startOfMonth = Carbon::parse($thang)->startOfMonth();
        $endOfMonth = Carbon::parse($thang)->endOfMonth();

        $thongKe = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfMonth, $endOfMonth])
            ->select(
                DB::raw('DATE(ngay_thanh_toan) as ngay'),
                'phuong_thuc_thanh_toan',
                DB::raw('COUNT(*) as so_luong_hoa_don'),
                DB::raw('SUM(tong_tien) as tong_doanh_thu')
            )
            ->groupBy('ngay', 'phuong_thuc_thanh_toan')
            ->orderBy('ngay')
            ->get();

        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfMonth, $endOfMonth])
            ->sum('tong_tien');

        return response()->json([
            'thang' => $thang,
            'thong_ke' => $thongKe,
            'tong_doanh_thu' => $tongDoanhThu
        ]);
    }

    public function thongKeTheoQuy(Request $request)
    {
        $nam = $request->nam ?? Carbon::now()->year;
        $quy = $request->quy ?? Carbon::now()->quarter;

        // Validate quarter input
        if ($quy < 1 || $quy > 4) {
            return response()->json([
                'error' => 'Quý phải là số từ 1 đến 4'
            ], 400);
        }

        // Calculate start and end dates for the quarter
        $startMonth = ($quy - 1) * 3 + 1;
        $startDate = Carbon::createFromDate($nam, $startMonth, 1)->startOfDay();
        $endDate = Carbon::createFromDate($nam, $startMonth + 2, 1)->endOfMonth()->endOfDay();

        $thongKe = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startDate, $endDate])
            ->select(
                DB::raw('MONTH(ngay_thanh_toan) as thang'),
                'phuong_thuc_thanh_toan',
                DB::raw('COUNT(*) as so_luong_hoa_don'),
                DB::raw('SUM(tong_tien) as tong_doanh_thu')
            )
            ->groupBy('thang', 'phuong_thuc_thanh_toan')
            ->orderBy('thang')
            ->get();

        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startDate, $endDate])
            ->sum('tong_tien');

        // Thêm thông tin chi tiết về quý
        $thongTinQuy = [
            'quy' => $quy,
            'nam' => $nam,
            'tu_ngay' => $startDate->format('Y-m-d'),
            'den_ngay' => $endDate->format('Y-m-d'),
            'cac_thang' => [
                $startMonth,
                $startMonth + 1,
                $startMonth + 2
            ]
        ];

        return response()->json([
            'thong_tin_quy' => $thongTinQuy,
            'thong_ke' => $thongKe,
            'tong_doanh_thu' => $tongDoanhThu,
            'message' => "Thống kê quý $quy năm $nam"
        ]);
    }

    public function thongKeTheoNam(Request $request)
    {
        $nam = $request->nam ?? Carbon::now()->year;
        $startOfYear = Carbon::create($nam)->startOfYear();
        $endOfYear = Carbon::create($nam)->endOfYear();

        $thongKe = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfYear, $endOfYear])
            ->select(
                DB::raw('MONTH(ngay_thanh_toan) as thang'),
                'phuong_thuc_thanh_toan',
                DB::raw('COUNT(*) as so_luong_hoa_don'),
                DB::raw('SUM(tong_tien) as tong_doanh_thu')
            )
            ->groupBy('thang', 'phuong_thuc_thanh_toan')
            ->orderBy('thang')
            ->get();

        $tongDoanhThu = HoaDon::where('trang_thai', 1)
            ->whereBetween('ngay_thanh_toan', [$startOfYear, $endOfYear])
            ->sum('tong_tien');

        return response()->json([
            'nam' => $nam,
            'thong_ke' => $thongKe,
            'tong_doanh_thu' => $tongDoanhThu
        ]);
    }
}
