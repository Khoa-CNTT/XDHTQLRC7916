<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\HoaDon;
use App\Models\QuanLyPhim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DanhGiaController extends Controller
{
    public function getData()
    {
        $data = DanhGia::leftjoin('khach_hangs', 'khach_hangs.id', 'danh_gias.id_khach_hang')
            ->leftjoin('quan_ly_phims', 'quan_ly_phims.id', 'danh_gias.id_phim')
            ->select('danh_gias.*', 'khach_hangs.ten_khach_hang', 'quan_ly_phims.ten_phim')
            ->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }
    public function getDataChiTietPhim($id)
    {
        try {
            // Using whereRaw with parameters to avoid SQL injection and handle special characters
        $data = DanhGia::leftjoin('khach_hangs', 'khach_hangs.id', 'danh_gias.id_khach_hang')
            ->leftjoin('quan_ly_phims', 'quan_ly_phims.id', 'danh_gias.id_phim')
            ->where('danh_gias.id_phim', $id)
            ->select('danh_gias.*', 'khach_hangs.ten_khach_hang', 'quan_ly_phims.ten_phim')
            ->get();

            return response()->json([
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'error' => 'Không thể lấy dữ liệu đánh giá'
            ]);
        }
    }
    public function danhGia(Request $request)
    {
        // Lấy thông tin từ request
        $noi_dung = $request->noi_dung;
        $id_phim = $request->phim_id; // Accept either id_phim or phim_id
        $id_khach_hang = $request->id_khach_hang;

        // Kiểm tra phim tồn tại
        $phim = QuanLyPhim::find($id_phim);
        if (!$phim) {
            return response()->json([
                'status' => false,
                'message' => 'Phim không tồn tại.',
            ]);
        }

        // Kiểm tra khách hàng đã xem phim chưa
        $hoaDon = HoaDon::join('chi_tiet_ves', 'chi_tiet_ves.id_hoa_don', 'hoa_dons.id')
        ->join('suat_chieus', 'suat_chieus.id', 'chi_tiet_ves.id_suat')
        ->where('hoa_dons.id_khach_hang', $id_khach_hang)
        ->where('suat_chieus.phim_id', $id_phim)
        ->where('hoa_dons.trang_thai', 1)
        ->first();

        if (!$hoaDon) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa xem phim này nên không thể đánh giá.',
            ]);
        }

        // Kiểm tra nội dung đánh giá
        if (empty(trim($noi_dung))) {
            return response()->json([
                'status' => false,
                'message' => 'Nội dung đánh giá không được để trống.',
            ]);
        }
        // Kiểm tra ID khách hàng
        if (empty($id_khach_hang)) {
            return response()->json([
                'status' => false,
                'message' => 'ID khách hàng không hợp lệ.',
            ]);
        }
        // Lưu đánh giá vào database
        $danh_gia = new DanhGia();
        $danh_gia->noi_dung = $noi_dung;
        $danh_gia->id_phim = $id_phim;
        $danh_gia->id_khach_hang = $id_khach_hang;
        $danh_gia->save();

        // Phản hồi thành công
        return response()->json([
            'status' => true,
            'message' => 'Đánh giá của bạn đã được gửi thành công.',
        ]);
    }
    public function createData(Request $request)
    {
        $data   =   $request->all();
        DanhGia::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới đánh giá thành công!'
        ]);
    }
    public function deleteData($id)
    {
        DanhGia::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá đánh giá thành công!'
        ]);
    }
    public function deleteDataClient($id)
    {
        $user = Auth::guard('sanctum')->user();
        DanhGia::where('id_khach_hang', $user->id)
        ->where('id', $id)
        ->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá đánh giá thành công!'
        ]);
    }
    public function updateDataClient(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data   = $request->all();
        DanhGia::where('id_khach_hang', $user->id)
        ->where('id', $request->id)
        ->update($data);
        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật đánh giá  thành công!'
        ]);
    }

    public function updateData(Request $request)
    {
        $data   = $request->all();
        DanhGia::find($request->id)->update($data);
        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật đánh giá  thành công!'
        ]);
    }
    public function doiTrangThai(Request $request)
    {
        $danh_gia = DanhGia::find($request->id);
        if ($danh_gia) {
            if ($danh_gia->tinh_trang == 1) {
                $danh_gia->tinh_trang = 0;
            } else {
                $danh_gia->tinh_trang = 1;
            }
            $danh_gia->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái đánh giá thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Đã có lỗi xảy ra!"
            ]);
        }
    }
}
