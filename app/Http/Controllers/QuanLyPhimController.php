<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuanLyPhim;
use App\Http\Requests\themMoiQuanLyPhim;
use App\Http\Requests\UpdateQuanLyPhim;
use App\Models\ChiTietTheLoai;
use App\Models\QuanLyPhim;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuanLyPhimController extends Controller
{
    public function getData()
    {
        $data = QuanLyPhim::with('theLoais')
        ->get();
        return response()->json([
            'quan_ly_phim' => $data,
        ]);
    }
    public function searchQuanLyPhim(Request $request)
    {
        $data = QuanLyPhim::with('theLoais')
            ->where('ten_phim', 'like', '%' . $request->abc . '%')
            ->get();
        return response()->json([
            'quan_ly_phim' => $data,
        ]);
    }
    public function themMoiQuanLyPhim(createQuanLyPhim $request)
    {
        try {
            $phim = QuanLyPhim::create([
                'ten_phim'              => $request->ten_phim,
                'ngay_chieu'            => $request->ngay_chieu,
                'thoi_luong'            => $request->thoi_luong,
                'slug_phim'             => $request->slug_phim,
                'dao_dien'              => $request->dao_dien,
                'hinh_anh'              => $request->hinh_anh,
                'trailer_ytb'           => $request->trailer_ytb,
                'dien_vien'             => $request->dien_vien,
                'nha_san_xuat'          => $request->nha_san_xuat,
                'gioi_han_do_tuoi'      => $request->gioi_han_do_tuoi,
                'mo_ta'                 => $request->mo_ta,
                'danh_gia'              => $request->danh_gia,
                'tinh_trang'            => $request->tinh_trang,
            ]);

            if ($request->has('id_the_loai')) {
                $phim->theLoais()->sync($request->id_the_loai);
            }


            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã tạo mới phim thành công!',
            ]);
        } catch (Exception $e) {
            Log::error("Lỗi thêm mới phim: " . $e->getMessage());
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi xảy ra khi thêm mới phim!',
            ], 500);
        }
    }
    public function xoaQuanLyPhim($id)
    {
        try {
            $phim = QuanLyPhim::find($id);
            if ($phim) {
                $phim->theLoais()->detach(); // Xóa các liên kết thể loại trước
                $phim->delete();
                return response()->json([
                    'status'            =>   true,
                    'message'           =>   'Xóa phim thành công!',
                ]);
            }
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Không tìm thấy phim!',
            ], 404);
        } catch (Exception $e) {
            Log::error("Lỗi xóa phim: " . $e->getMessage());
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi xảy ra khi xóa phim!',
            ], 500);
        }
    }
    public function doiTrangThaiQuanLyPhim(Request $request)
    {
        try {
            $tinh_trang_moi = $request->tinh_trang == 1 ? 0 : 1;

            $phim = QuanLyPhim::find($request->id);
            if ($phim) {
                $phim->update(['tinh_trang' => $tinh_trang_moi]);
                return response()->json([
                    'status'            =>   true,
                    'message'           =>   'Đã đổi trạng thái thành công',
                ]);
            }
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Không tìm thấy phim!',
            ], 404);
        } catch (Exception $e) {
            Log::error("Lỗi đổi trạng thái: " . $e->getMessage());
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi xảy ra khi đổi trạng thái!',
            ], 500);
        }
    }
    public function createQuanLyPhim(UpdateQuanLyPhim $request)
    {
        try {
            $phim = QuanLyPhim::find($request->id);
            if ($phim) {
                // Update all fields except id_the_loai
                $phim->update([
                    'ten_phim'              => $request->ten_phim,
                    'ngay_chieu'            => $request->ngay_chieu,
                    'thoi_luong'            => $request->thoi_luong,
                    'slug_phim'             => $request->slug_phim,
                    'dao_dien'              => $request->dao_dien,
                    'hinh_anh'              => $request->hinh_anh,
                    'trailer_ytb'           => $request->trailer_ytb,
                    'dien_vien'             => $request->dien_vien,
                    'nha_san_xuat'          => $request->nha_san_xuat,
                    'gioi_han_do_tuoi'      => $request->gioi_han_do_tuoi,
                    'mo_ta'                 => $request->mo_ta,
                    'danh_gia'              => $request->danh_gia,
                    'tinh_trang'            => $request->tinh_trang,
                ]);

                // Update the genres using sync
                if ($request->has('id_the_loai')) {
                    $phim->theLoais()->sync($request->id_the_loai);
                }



                return response()->json([
                    'status'    => true,
                    'message'   => 'Đã cập nhật thành công phim',
                ]);
            }
            return response()->json([
                'status'    => false,
                'message'   => 'Không tìm thấy phim!',
            ], 404);
        } catch (Exception $e) {
            Log::error("Lỗi cập nhật phim: " . $e->getMessage());
            return response()->json([
                'status'    => false,
                'message'   => 'Có lỗi xảy ra khi cập nhật phim!',
            ], 500);
        }
    }

    public function phimChiTiet($id)
    {
        try {
            $phim = QuanLyPhim::with('theLoais')->find($id);

            if ($phim) {
                return response()->json([
                    'status' => true,
                    'data' => $phim
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => "Không tìm thấy phim!"
            ], 404);
        } catch (Exception $e) {
            Log::error("Lỗi lấy chi tiết phim: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra khi lấy chi tiết phim!"
            ], 500);
        }
    }
}
