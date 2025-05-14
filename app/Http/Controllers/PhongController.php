<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhong;
use App\Http\Requests\UpdatePhong;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhongController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 47;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   Phong::all();

        return response()->json([
            'phong'  =>  $data
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   Phong::all();

                return response()->json([
                    'phong'  =>  $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }


    }

    public function store(CreatePhong $request)
    {
        $id_chuc_nang = 48;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
        Phong::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới phòng thành công!'
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   $request->all();
                Phong::create($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã tạo mới phòng thành công!'
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
        $id_chuc_nang = 50;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            Phong::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá phòng thành công!'
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                Phong::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá phòng thành công!'
        ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }


    }

    public function update(UpdatePhong $request)
    {
        $id_chuc_nang = 70;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();

        Phong::find($request->id)->update($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật phòng thành công!'
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();

        Phong::find($request->id)->update($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật phòng thành công!'
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
        $id_chuc_nang = 51;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $phong = Phong::find($request->id);
        if ($phong) {
            if ($phong->tinh_trang == 1) {
                $phong->tinh_trang = 0;
            } else {
                $phong->tinh_trang = 1;
            }
            $phong->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái phòng thành công!"
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
                $phong = Phong::find($request->id);
        if ($phong) {
            if ($phong->tinh_trang == 1) {
                $phong->tinh_trang = 0;
            } else {
                $phong->tinh_trang = 1;
            }
            $phong->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái phòng thành công!"
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
