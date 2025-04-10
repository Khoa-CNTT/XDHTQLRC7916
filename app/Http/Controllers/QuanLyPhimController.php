<?php

namespace App\Http\Controllers;

use App\Http\Requests\themMoiQuanLyPhim;
use App\Models\QuanLyPhim;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuanLyPhimController extends Controller
{
    public function getData()
    {
        $data = QuanLyPhim::all();
        return response()->json([
            'quan_ly_phim' => $data,
        ]);
    }
    public function searchQuanLyPhim(Request $request)
    {
        $data = QuanLyPhim::select("id", 'ten_phim', 'ngay_chieu', 'thoi_luong', 'dao_dien', 'hinh_anh', 'dien_vien', 'nha_san_xuat', 'id_the_loai', 'gioi_han_do_tuoi', "mo_ta", "danh_gia", "tinh_trang")
            ->where('ten_phim', $request->abc)
            ->get();
        return response()->json([
            'quan_ly_phim' => $data,
        ]);
    }
    public function themMoiQuanLyPhim(Request $request)
    {
        // $data = $request->all();
        // QuanLyPhim::create($data);
        QuanLyPhim::create([
            'ten_phim'              => $request->ten_phim,
            'ngay_chieu'            => $request->ngay_chieu,
            'thoi_luong'            => $request->thoi_luong,
            'slug_phim'             => $request->slug_phim,
            'dao_dien'              => $request->dao_dien,
            'hinh_anh'              => $request->hinh_anh,
            'trailer_ytb'           => $request->trailer_ytb,
            'dien_vien'             => $request->dien_vien,
            'nha_san_xuat'          => $request->nha_san_xuat,
            'id_the_loai'           => $request->id_the_loai,
            'gioi_han_do_tuoi'      => $request->gioi_han_do_tuoi,
            'mo_ta'                 => $request->mo_ta,
            'danh_gia'              => $request->danh_gia,
            'tinh_trang'            => $request->tinh_trang,
        ]);
        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới phim thành công!',
        ]);
    }
    public function xoaQuanLyPhim($id)
    {
        try {
            QuanLyPhim::where('id', $id)->delete();
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Xóa phim thành công!',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function doiTrangThaiQuanLyPhim(Request $request)
    {
        try {
            if ($request->tinh_trang == 1) {
                $tinh_trang_moi = 0;
            } else {
                $tinh_trang_moi = 1;
            }
            QuanLyPhim::where('id', $request->id)
                ->update([
                    'tinh_trang'  => $tinh_trang_moi,
                ]);
            return response()->json([
                'status'            =>   true,
                'message'           =>   'Đã đổi trạng thái thành công',
            ]);
        } catch (Exception $e) {
            Log::info("Lỗi", $e);
            return response()->json([
                'status'            =>   false,
                'message'           =>   'Có lỗi',
            ]);
        }
    }
    public function createQuanLyPhim(Request $request)
    {
        $data = $request->all();
        QuanLyPhim::find($request->id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhật thành công Quan Ly Phim',
        ]);
        // $data = $request->all();
        // $qlFilm = QuanLyPhim::find($request->id);
        // if ($qlFilm) {
        //     $qlFilm->update($data);
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Đã cập nhật thành công Quan Ly Phim',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Không tìm thấy Quan Ly Phim',
        //     ]);
        // }
    }

    public function phimChiTiet($id)
    {
        $phim = QuanLyPhim::join('the_loais', 'quan_ly_phims.id_the_loai', 'the_loais.id')
            ->where('quan_ly_phims.id', $id)
            ->select('quan_ly_phims.*', 'the_loais.ten_the_loai')
            ->first();

        if ($phim) {
            return response()->json([
                'status' => true,
                'data' => $phim
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Không có phim!"
            ]);
        }
    }
}
