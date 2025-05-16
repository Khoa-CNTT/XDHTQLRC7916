<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuKienRequest;
use App\Http\Requests\UpdateSuKienRequest;
use App\Models\SuKien;
use Illuminate\Http\Request;

class SuKienController extends Controller
{
    public function getData(){
        $data   =   SuKien::all();
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function getDataSuKien(){
        $data   =   SuKien::where('tinh_trang', 1)->get();
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function getChiTietSuKien($id){
        $data   =   SuKien::find($id);
        return response()->json([
            'data'  =>  $data
        ]);
    }

    public function createData(CreateSuKienRequest $request){
        $data   =   $request->all();
        SuKien::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới sự kiện thành công!'
        ]);
    }

    public function deleteData($id)
    {
        SuKien::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá sự kiện thành công!'
        ]);
    }

    public function updateData(UpdateSuKienRequest $request)
    {
        $data   = $request->all();
        SuKien::find($request->id)->update($data);
        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật sự kiện thành công!'
        ]);
    }

    public function doiTrangThai(Request $request){
        $su_kien = SuKien::find($request->id);
        if($su_kien) {
            if($su_kien->tinh_trang == 1) {
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
    }
}
