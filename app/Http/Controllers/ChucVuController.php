<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChucVu;
use App\Http\Requests\UpdateChucVu;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChucVuController extends Controller
{
    public function getData(){
        $id_chuc_nang = 25;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   ChucVu::all();
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
                $data   =   ChucVu::all();
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
    public function getDataOP(){
        $data   =   ChucVu::where('tinh_trang',1)
                   ->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }
    public function createData(CreateChucVu $request){
        $id_chuc_nang = 26;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
        ChucVu::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới chức vụ thành công!'
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   $request->all();
                ChucVu::create($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã tạo mới chức vụ thành công!'
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
        $id_chuc_nang = 27;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            ChucVu::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá chức vụ thành công!'
        ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                ChucVu::find($id)->delete();

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá chức vụ thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }


    }

    public function updateData(UpdateChucVu $request)
    {
        $id_chuc_nang = 66;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();
            ChucVu::find($request->id)->update($data);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật chứ vụ  thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();
        ChucVu::find($request->id)->update($data);
        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật chứ vụ  thành công!'
        ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }


    }
    public function doiTrangThai(Request $request){
        $id_chuc_nang = 29;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $chuc_vu = ChucVu::find($request->id);
        if($chuc_vu) {
            if($chuc_vu->tinh_trang == 1) {
                $chuc_vu->tinh_trang = 0;
            } else {
                $chuc_vu->tinh_trang = 1;
            }
            $chuc_vu->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái chức vụ thành công!"
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
                $chuc_vu = ChucVu::find($request->id);
                if($chuc_vu) {
                    if($chuc_vu->tinh_trang == 1) {
                        $chuc_vu->tinh_trang = 0;
                    } else {
                        $chuc_vu->tinh_trang = 1;
                    }
                    $chuc_vu->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái chức vụ thành công!"
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
    public function doiMaster(Request $request){
        $id_chuc_nang = 60;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {

        $chuc_vu = ChucVu::find($request->id);
        if($chuc_vu) {
            if($chuc_vu->is_master == 1) {
                $chuc_vu->is_master = 0;
            } else {
                $chuc_vu->is_master = 1;
            }
            $chuc_vu->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái chức vụ thành công!"
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

        $chuc_vu = ChucVu::find($request->id);
        if($chuc_vu) {
            if($chuc_vu->is_master == 1) {
                $chuc_vu->is_master = 0;
            } else {
                $chuc_vu->is_master = 1;
            }
            $chuc_vu->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái chức vụ thành công!"
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
