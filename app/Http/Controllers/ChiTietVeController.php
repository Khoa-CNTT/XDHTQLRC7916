<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChiTietVe;
use App\Models\ChucVu;
use App\Models\Ghe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ChiTietVeController extends Controller
{



    public function getData()
    {
        $data = ChiTietVe::join('suat_chieus', 'chi_tiet_ves.id_suat', '=', 'suat_chieus.id')
            ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id')
            ->join('ghes', 'chi_tiet_ves.id_ghe', '=', 'ghes.id')
            ->join('phongs', 'ghes.phong_id', '=', 'phongs.id')
            ->leftJoin('khach_hangs', 'chi_tiet_ves.id_khach_hang', '=', 'khach_hangs.id')
            ->leftJoin('hoa_dons', 'chi_tiet_ves.id_hoa_don', '=', 'hoa_dons.id')
            ->select(
                'chi_tiet_ves.id_suat',
                'chi_tiet_ves.id',
                'chi_tiet_ves.gia_tien',
                'chi_tiet_ves.tinh_trang',
                'quan_ly_phims.ten_phim',
                'suat_chieus.ngay_chieu',
                'suat_chieus.gio_bat_dau',
                'suat_chieus.gio_ket_thuc',
                'suat_chieus.dinh_dang',
                'suat_chieus.ngon_ngu',
                'ghes.ten_ghe',
                'ghes.hang',
                'ghes.cot',
                'ghes.loai_ghe',
                'phongs.ten_phong',
                'phongs.id as id_phong',
                'khach_hangs.ten_khach_hang',
                'hoa_dons.ma_hoa_don',
                'hoa_dons.trang_thai as trang_thai_hoa_don'
            )
            ->orderBy('chi_tiet_ves.created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }


    public function store(Request $request)
    {
        $data   =   $request->all();
        ChiTietVe::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới vé thành công!'
        ]);
    }

    public function destroy($id)
    {
        $id_chuc_nang = 59;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $ve = ChiTietVe::where('id', $id)->first();
            $ve->tinh_trang = 0;
            $ve->save();
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xoá vé thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $ve = ChiTietVe::where('id', $id)->first();
                $ve->tinh_trang = 0;
                $ve->save();
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá vé thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }


    public function update(Request $request)
    {
        $id_chuc_nang = 72;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();

            ChiTietVe::find($request->id)->update($data);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật vé thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();

                ChiTietVe::find($request->id)->update($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã cập nhật vé thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    // Trong ChiTietVeController.php
    public function getDataOpen()
    {
        $data = ChiTietVe::join('ghes', 'chi_tiet_ves.id_ghe', 'ghes.id')
            ->join('suat_chieus', 'chi_tiet_ves.id_suat', 'suat_chieus.id')
            ->join('phongs', 'suat_chieus.phong_id', 'phongs.id')
            ->select(
                'chi_tiet_ves.*',
                'ghes.ten_ghe',
                'ghes.hang',
                'ghes.cot',
                'ghes.loai_ghe',
                'ghes.trang_thai as trang_thai_ghe',
                'phongs.ten_phong'
            )
            ->orderBy('ghes.hang', 'asc')
            ->orderBy('ghes.cot', 'asc')
            ->get();

        // Tổ chức ghế theo hàng và cột để dễ hiển thị sơ đồ
        $gheTheoHang = [];
        foreach ($data as $ghe) {
            if (!isset($gheTheoHang[$ghe->hang])) {
                $gheTheoHang[$ghe->hang] = [];
            }
            $gheTheoHang[$ghe->hang][$ghe->cot] = [
                'id' => $ghe->id,
                'id_ghe' => $ghe->id_ghe,
                'ten_ghe' => $ghe->ten_ghe,
                'loai_ghe' => $ghe->loai_ghe,
                'tinh_trang' => $ghe->tinh_trang,
                'trang_thai_ghe' => $ghe->trang_thai_ghe,
                'gia_tien' => $ghe->gia_tien,
                'id_khach_hang' => $ghe->id_khach_hang
            ];
        }

        return response()->json([
            'data' => $data,
            'ghe_theo_hang' => $gheTheoHang
        ]);
    }

    public function chaneStatusDat(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\KhachHang) {
            $ve = ChiTietVe::where('id_ghe', $request->id_ghe)
                ->where('id_suat', $request->id_suat)
                ->first();
            if ($ve) {
                if ($ve->tinh_trang == 0) {
                    $ve->tinh_trang = 1;
                    $ve->id_khach_hang = $request->id_khach_hang;
                    $ve->ma_check = $request->id_khach_hang . 'kh';
                    $ve->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đã chọn ghế thành công!"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Đã có lỗi xảy ra!"
                ]);
            }
        } else {
            $ve = ChiTietVe::where('id_ghe', $request->id_ghe)
                ->where('id_suat', $request->id_suat)
                ->first();
            if ($ve) {
                if ($ve->tinh_trang == 0) {
                    $ve->tinh_trang = 1;
                    $ve->id_nhan_vien = $user->id;
                    $ve->ma_check = $user->id . 'nv';
                    $ve->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đã chọn ghế thành công!"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Đã có lỗi xảy ra!"
                ]);
            }
        }
    }

    public function chaneStatusHuy(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\KhachHang) {
            $ve = ChiTietVe::where('id_ghe', $request->id_ghe)
                ->where('id_suat', $request->id_suat)
                ->first();
            if ($ve) {
                if ($ve->ma_check == $request->id_khach_hang . 'kh' && $ve->tinh_trang == 1) {
                    $ve->tinh_trang = 0;

                    $ve->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi huỷ ghế thành công!"
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Ghế này đã được đặt!"
                    ]);
                }
            }
        } else {
            $ve = ChiTietVe::where('id_ghe', $request->id_ghe)
                ->where('id_suat', $request->id_suat)
                ->first();
            if ($ve) {
                if ($ve->ma_check == $user->id . 'nv' && $ve->tinh_trang == 1) {
                    $ve->tinh_trang = 0;

                    $ve->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi huỷ ghế thành công!"
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Ghế này đã được đặt!"
                    ]);
                }
            }
        }
    }
    public function kiemTraTrangThai(Request $request)
    {
        return response()->json([
                    'status' => true,
                ]);
        // $ve = ChiTietVe::where('id_ghe', $request->id_ghe)
        //     ->where('id_suat', $request->id_suat)
        //     ->first();
        // if ($ve) {
        //     if ($ve->id_khach_hang == $request->id_khach_hang && $ve->tinh_trang == 1) {
        //         $ve->tinh_trang = 0;

        //         $ve->save();

        //         return response()->json([
        //             'status' => true,
        //             'message' => "Đã huỷ ghế thành công! Do đã quá thời gian thanh toán"
        //         ]);
        //     }
        // }
    }
    public function getData1($id)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\KhachHang) {
            $data   =   ChiTietVe::leftjoin('ghes', 'chi_tiet_ves.id_ghe', 'ghes.id')
                ->where('chi_tiet_ves.id_khach_hang', $user->id)
                ->where('chi_tiet_ves.id_suat', $id)
                ->where('chi_tiet_ves.tinh_trang', 1)
                ->select('chi_tiet_ves.*', 'ghes.ten_ghe')
                ->get();
            $tongTien = $data->sum('gia_tien');
            return response()->json([
                'data' => $data,
                'tong_tien' => $tongTien
            ]);
        } else {
            $data   =   ChiTietVe::leftjoin('ghes', 'chi_tiet_ves.id_ghe', 'ghes.id')
                ->where('chi_tiet_ves.id_nhan_vien', $user->id)
                ->where('chi_tiet_ves.id_suat', $id)
                ->where('chi_tiet_ves.tinh_trang', 1)
                ->select('chi_tiet_ves.*', 'ghes.ten_ghe')
                ->get();
            $tongTien = $data->sum('gia_tien');
            return response()->json([
                'data' => $data,
                'tong_tien' => $tongTien
            ]);
        }
    }

    public function layTheoSuat($id_suat)
    {
        try {
            $data = ChiTietVe::leftJoin('khach_hangs', 'chi_tiet_ves.id_khach_hang', 'khach_hangs.id')
                ->leftJoin('hoa_dons', 'chi_tiet_ves.id_hoa_don', 'hoa_dons.id')
                ->leftJoin('ghes', 'chi_tiet_ves.id_ghe', 'ghes.id')
                ->where('chi_tiet_ves.id_suat', $id_suat)
                ->select(
                    'chi_tiet_ves.id',
                    'chi_tiet_ves.id_suat',
                    'chi_tiet_ves.id_ghe',
                    'chi_tiet_ves.id_khach_hang',
                    'chi_tiet_ves.id_hoa_don',
                    'chi_tiet_ves.gia_tien',
                    'chi_tiet_ves.tinh_trang',
                    'chi_tiet_ves.ghi_chu',
                    'khach_hangs.ten_khach_hang',
                    'hoa_dons.ma_hoa_don',
                    'ghes.ten_ghe',
                    'ghes.hang',
                    'ghes.cot',
                    'ghes.loai_ghe',
                    'ghes.trang_thai as trang_thai_ghe'
                )
                ->get();

            return response()->json([
                'status'    => true,
                'data'      => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra khi lấy dữ liệu vé!',
                'error'     => $e->getMessage()
            ]);
        }
    }

    public function kiemTraDatVe(Request $request)
    {
        $suatChieuId = $request->query('suat_chieu_id');
        $daCoNguoiDat = \App\Models\ChiTietVe::where('id_suat', $suatChieuId)
            ->where('tinh_trang', 1)
            ->exists();

        return response()->json([
            'da_co_nguoi_dat' => $daCoNguoiDat
        ]);
    }
}
