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


    // Tạo ghế mới
    public function createData(CreateGhe $request)
    {
        $request->validate([
            'ten_ghe' => 'required|string',
            'phong_id' => 'required|exists:phongs,id',
            'hang' => 'required|integer',
            'cot' => 'required|integer',
            'loai_ghe' => 'required|in:0,1,2', // 0: Thường, 1: VIP, 3: ghế đôi
            'trang_thai' => 'required|in:0,1', // 0: Không hoạt động, 1: Hoạt động
        ]);

        $id_chuc_nang = 31;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = $request->all();
            Ghe::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Thêm mới ghế thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {

                $data = $request->all();
                Ghe::create($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Thêm mới ghế thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }




    }

    // Tạo nhiều ghế cùng lúc cho một phòng
    public function createMultipleGhe(CreateGhe $request)
    {
        $request->validate([
            'phong_id' => 'required|exists:phongs,id',
            'so_hang' => 'required|integer|min:1',
            'so_cot' => 'required|integer|min:1',
        ]);

        $phongId = $request->phong_id;
        $soHang = $request->so_hang;
        $soCot = $request->so_cot;

        // Xóa ghế cũ của phòng (nếu cần)
        if ($request->xoa_ghe_cu) {
            Ghe::where('phong_id', $phongId)->delete();
        }

        // Tạo ghế mới
        $hangChars = range('A', 'Z'); // A-Z cho hàng
        $gheData = [];

        for ($i = 0; $i < $soHang; $i++) {
            $hang = $hangChars[$i];
            for ($j = 1; $j <= $soCot; $j++) {
                $gheData[] = [
                    'ten_ghe' => $hang . $j,
                    'phong_id' => $phongId,
                    'hang' => $i + 1,
                    'cot' => $j,
                    'loai_ghe' => 0, // Mặc định là ghế thường
                    'trang_thai' => 1, // Mặc định là hoạt động
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Thêm ghế vào database
        Ghe::insert($gheData);

        return response()->json([
            'status' => true,
            'message' => "Đã tạo $soHang hàng, $soCot cột ghế cho phòng thành công!"
        ]);
    }

    // Cập nhật ghế
    public function updateData(UpdateGhe $request)
    {
        $request->validate([
            'id' => 'required|exists:ghes,id',
            'ten_ghe' => 'required|string',
            'phong_id' => 'required|exists:phongs,id',
            'hang' => 'required|integer',
            'cot' => 'required|integer',
            'loai_ghe' => 'required|in:0,1,2',
            'trang_thai' => 'required|in:0,1',
        ]);

        $id_chuc_nang = 67;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = $request->all();
            Ghe::find($request->id)->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật ghế thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data = $request->all();
        Ghe::find($request->id)->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật ghế thành công!'
        ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }


    }

    // Xóa ghế
    public function deleteData($id)
    {
        $id_chuc_nang = 33;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
             // Kiểm tra xem ghế đã được đặt trong bất kỳ suất chiếu nào chưa
        $daCoNguoiDat = ChiTietVe::where('id_ghe', $id)
        ->where('tinh_trang', 1)
        ->exists();

    if ($daCoNguoiDat) {
        return response()->json([
            'status' => false,
            'message' => 'Không thể xóa ghế đã có người đặt!'
        ]);
    }

    Ghe::find($id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Đã xóa ghế thành công!'
    ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                // Kiểm tra xem ghế đã được đặt trong bất kỳ suất chiếu nào chưa
        $daCoNguoiDat = ChiTietVe::where('id_ghe', $id)
        ->where('tinh_trang', 1)
        ->exists();

    if ($daCoNguoiDat) {
        return response()->json([
            'status' => false,
            'message' => 'Không thể xóa ghế đã có người đặt!'
        ]);
    }

    Ghe::find($id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Đã xóa ghế thành công!'
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
                    'message' => "Đổi trạng thái ghế thành công!"
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

}
