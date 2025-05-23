<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGocDienAnhRequest;
use App\Http\Requests\UpdateGocDienAnhRequest;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\GocDienAnh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GocDienAnhController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 92;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = GocDienAnh::orderBy('ngay_dang', 'desc')->get();
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
                $data = GocDienAnh::orderBy('ngay_dang', 'desc')->get();
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

    public function getDataOP()
    {
        $data = GocDienAnh::where('trang_thai',1)
                            ->orderBy('ngay_dang', 'desc')->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function createData(CreateGocDienAnhRequest $request)
    {
        $id_chuc_nang = 73;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = $request->all();
            $data['ngay_dang'] = now();

            GocDienAnh::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Đã tạo mới góc điện ảnh thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data = $request->all();
                $data['ngay_dang'] = now();

                GocDienAnh::create($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Đã tạo mới góc điện ảnh thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function updateData(UpdateGocDienAnhRequest $request)
    {
        $id_chuc_nang = 75;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $gocDienAnh = GocDienAnh::find($request->id);

            if (!$gocDienAnh) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy góc điện ảnh!'
                ]);
            }

            $data = $request->except('id'); // Bỏ id ra khỏi dữ liệu cập nhật
            $gocDienAnh->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật góc điện ảnh thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $gocDienAnh = GocDienAnh::find($request->id);

                if (!$gocDienAnh) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Không tìm thấy góc điện ảnh!'
                    ]);
                }

                $data = $request->except('id'); // Bỏ id ra khỏi dữ liệu cập nhật
                $gocDienAnh->update($data);

                return response()->json([
                    'status' => true,
                    'message' => 'Đã cập nhật góc điện ảnh thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }


    public function deleteData($id)
    {
        $id_chuc_nang = 74;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            GocDienAnh::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Đã xoá góc điện ảnh thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                GocDienAnh::find($id)->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Đã xoá góc điện ảnh thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function doiTrangThai(Request $request)
    {

        $id_chuc_nang = 76;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $goc_dien_anh = GocDienAnh::find($request->id);
            if ($goc_dien_anh) {
                $goc_dien_anh->trang_thai = !$goc_dien_anh->trang_thai;
                $goc_dien_anh->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi trạng thái góc điện ảnh thành công!"
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
                $goc_dien_anh = GocDienAnh::find($request->id);
                if ($goc_dien_anh) {
                    $goc_dien_anh->trang_thai = !$goc_dien_anh->trang_thai;
                    $goc_dien_anh->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái góc điện ảnh thành công!"
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

    public function getDataById($id)
    {
        $goc_dien_anh = GocDienAnh::find($id);

        if ($goc_dien_anh) {
            return response()->json([
                'status' => true,
                'data' => $goc_dien_anh
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy thông tin góc điện ảnh!'
        ]);
    }
}
