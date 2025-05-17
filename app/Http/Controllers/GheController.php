<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGhe;
use App\Http\Requests\UpdateGhe;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChiTietVe;
use App\Models\ChucVu;
use App\Models\Ghe;
use App\Models\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GheController extends Controller
{
    // Lấy tất cả ghế
    public function getData()
    {
        $id_chuc_nang = 30;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = Ghe::with('phong')
                ->orderBy('ten_ghe', 'asc')
                ->get();

            return response()->json([
                'data' => $data
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data = Ghe::with('phong')
                    ->orderBy('ten_ghe', 'asc')
                    ->get();

                return response()->json([
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    // Đổi trạng thái ghế
    public function doiTrangThai(Request $request)
    {
        $id_chuc_nang = 34;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $ghe = Ghe::find($request->id);
            if ($ghe) {
                // Kiểm tra xem ghế đã được đặt trong bất kỳ suất chiếu nào chưa
                $daCoNguoiDat = ChiTietVe::where('id_ghe', $ghe->id)
                    ->where('tinh_trang', 1)
                    ->exists();

                if ($daCoNguoiDat && $ghe->trang_thai == 1) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Không thể vô hiệu hóa ghế đã có người đặt!'
                    ]);
                }

                if ($ghe->trang_thai == 1) {
                    $ghe->trang_thai = 0;
                } else {
                    $ghe->trang_thai = 1;
                }
                $ghe->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã đổi trạng thái thành công!"
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Đã có lỗi xảy ra!"
                ]);
            }
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $ghe = Ghe::find($request->id);
                if ($ghe) {
                    // Kiểm tra xem ghế đã được đặt trong bất kỳ suất chiếu nào chưa
                    $daCoNguoiDat = ChiTietVe::where('id_ghe', $ghe->id)
                        ->where('tinh_trang', 1)
                        ->exists();

                    if ($daCoNguoiDat && $ghe->trang_thai == 1) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Không thể vô hiệu hóa ghế đã có người đặt!'
                        ]);
                    }

                    if ($ghe->trang_thai == 1) {
                        $ghe->trang_thai = 0;
                    } else {
                        $ghe->trang_thai = 1;
                    }
                    $ghe->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái ghế thành công!"
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Đã có lỗi xảy ra!"
                    ]);
                }
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    // Đổi loại ghế
    public function doiLoaiGhe(Request $request)
    {
        $id_chuc_nang = 35;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $ghe = Ghe::find($request->id);
            if ($ghe) {
                if ($ghe->loai_ghe == 1) {
                    $ghe->loai_ghe = 0; // Chuyển từ VIP sang Thường
                } else {
                    $ghe->loai_ghe = 1; // Chuyển từ Thường sang VIP
                }
                $ghe->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi loại ghế thành công!"
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Đã có lỗi xảy ra!"
                ]);
            }
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $ghe = Ghe::find($request->id);
                if ($ghe) {
                    if ($ghe->loai_ghe == 1) {
                        $ghe->loai_ghe = 0; // Chuyển từ VIP sang Thường
                    } else {
                        $ghe->loai_ghe = 1; // Chuyển từ Thường sang VIP
                    }
                    $ghe->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi loại ghế thành công!"
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => "Đã có lỗi xảy ra!"
                    ]);
                }
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    // Lấy ghế theo phòng
    public function getGheTheoPhong($phongId)
    {
        $data = Ghe::where('phong_id', $phongId)
            ->orderBy('hang', 'asc')
            ->orderBy('cot', 'asc')
            ->get();

        // Tổ chức ghế theo hàng và cột để dễ hiển thị sơ đồ
        $soDoGhe = [];
        foreach ($data as $ghe) {
            if (!isset($soDoGhe[$ghe->hang])) {
                $soDoGhe[$ghe->hang] = [];
            }
            $soDoGhe[$ghe->hang][$ghe->cot] = $ghe;
        }

        return response()->json([
            'status' => true,
            'so_do_ghe' => $soDoGhe,
            'danh_sach_ghe' => $data
        ]);
    }
    //tim kiem ghe
    public function search(Request $request)
    {
        $id_chuc_nang = 30; // Using same permission as getData since it's a read operation
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();

        $query = Ghe::query()->with('phong');

        // Apply search filters
        if ($request->has('ten_ghe')) {
            $query->where('ten_ghe', 'like', '%' . $request->ten_ghe . '%');
        }

        if ($request->has('phong_id')) {
            $query->where('phong_id', $request->phong_id);
        }

        if ($request->has('loai_ghe')) {
            $query->where('loai_ghe', $request->loai_ghe);
        }

        if ($request->has('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($master->is_master) {
            $data = $query->orderBy('ten_ghe', 'asc')->get();
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();

            if ($check) {
                $data = $query->orderBy('ten_ghe', 'asc')->get();
                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Bạn không có quyền này'
                ]);
            }
        }
    }
}
