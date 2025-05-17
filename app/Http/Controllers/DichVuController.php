<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDichVuRequest;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\DichVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DichVuController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 15;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   DichVu::all();
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
                $data   =   DichVu::all();
                return response()->json([
                    'data'  =>  $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }
    public function getDataDichVu()
    {
        $data   =   DichVu::where('tinh_trang', 1)->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }
    public function getDataDichVuKhuyenMai()
    {
        $data   =   DichVu::take(8)->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }
    public function createData(CreateDichVuRequest $request)
    {
        $id_chuc_nang = 16;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
            DichVu::create($data);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã tạo mới dịch vụ thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   $request->all();
                DichVu::create($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã tạo mới dịch vụ thành công!'
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
        $id_chuc_nang = 18;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            DichVu::find($id)->delete();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xoá dịch vụ thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                DichVu::find($id)->delete();

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá dịch vụ thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function updateData(Request $request)
    {
        $id_chuc_nang = 64;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();
            DichVu::find($request->id)->update($data);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật dịch vụ thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();
                DichVu::find($request->id)->update($data);
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã cập nhật dịch vụ thành công!'
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
        $id_chuc_nang = 19;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $dich_vu = DichVu::find($request->id);
            if ($dich_vu) {
                if ($dich_vu->tinh_trang == 1) {
                    $dich_vu->tinh_trang = 0;
                } else {
                    $dich_vu->tinh_trang = 1;
                }
                $dich_vu->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi trạng thái dịch vụ thành công!"
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
                $dich_vu = DichVu::find($request->id);
                if ($dich_vu) {
                    if ($dich_vu->tinh_trang == 1) {
                        $dich_vu->tinh_trang = 0;
                    } else {
                        $dich_vu->tinh_trang = 1;
                    }
                    $dich_vu->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái dịch vụ thành công!"
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
