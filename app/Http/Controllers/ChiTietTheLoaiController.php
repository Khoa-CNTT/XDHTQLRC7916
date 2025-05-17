<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChiTietTheLoai;
use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiTietTheLoaiController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 52;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   ChiTietTheLoai::all();

            return response()->json([
                'status'      =>  true,
                'data'  =>  $data
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   ChiTietTheLoai::all();

                return response()->json([
                    'status'      =>  true,
                    'data'  =>  $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function store(Request $request)
    {
        $id_chuc_nang = 53;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
            ChiTietTheLoai::create($data);

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
                ChiTietTheLoai::create($data);

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

    public function destroy($id)
    {
        $id_chuc_nang = 53;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            ChiTietTheLoai::find($id)->delete();

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
                ChiTietTheLoai::find($id)->delete();

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


    public function update(Request $request)
    {
        $id_chuc_nang = 71;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();

            ChiTietTheLoai::find($request->id)->update($data);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Cập nhật dịch vụ thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();

                ChiTietTheLoai::find($request->id)->update($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Cập nhật dịch vụ thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }
}
