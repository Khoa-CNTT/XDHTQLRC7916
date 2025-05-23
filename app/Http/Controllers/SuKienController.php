<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuKienRequest;
use App\Http\Requests\UpdateSuKienRequest;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\SuKien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuKienController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 93;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   SuKien::all();
            return response()->json([
                'data'  =>  $data
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   SuKien::all();
                return response()->json([
                    'data'  =>  $data
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    "message" => 'bạn không có quyền này',
                ]);
            }
        }
    }

    public function getDataSuKien()
    {
        $data   =   SuKien::where('tinh_trang', 1)->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function getChiTietSuKien($id)
    {
        $data   =   SuKien::find($id);
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function createData(CreateSuKienRequest $request)
    {
        $id_chuc_nang = 77;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
            SuKien::create($data);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã tạo mới sự kiện thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   $request->all();
                SuKien::create($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã tạo mới sự kiện thành công!'
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
        $id_chuc_nang = 78;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            SuKien::find($id)->delete();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xoá sự kiện thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                SuKien::find($id)->delete();

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá sự kiện thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function updateData(UpdateSuKienRequest $request)
    {
        $id_chuc_nang = 79;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();
            SuKien::find($request->id)->update($data);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật sự kiện thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();
                SuKien::find($request->id)->update($data);
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã cập nhật sự kiện thành công!'
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
        $id_chuc_nang = 80;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $su_kien = SuKien::find($request->id);
            if ($su_kien) {
                if ($su_kien->tinh_trang == 1) {
                    $su_kien->tinh_trang = 0;
                } else {
                    $su_kien->tinh_trang = 1;
                }
                $su_kien->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi trạng thái sự kiện thành công!"
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
                $su_kien = SuKien::find($request->id);
                if ($su_kien) {
                    if ($su_kien->tinh_trang == 1) {
                        $su_kien->tinh_trang = 0;
                    } else {
                        $su_kien->tinh_trang = 1;
                    }
                    $su_kien->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái sự kiện thành công!"
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
}
