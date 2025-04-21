<?php

namespace App\Http\Controllers;

use App\Models\Baner;
use Illuminate\Http\Request;

class BanerController extends Controller
{
    public function getData()
    {
        $data   =   Baner::where('tinh_trang', 1)
                        ->get();
        return response()->json([
            'slide'  =>  $data
        ]);
    }

    public function store(Request $request)
    {
        $data   =   $request->all();
        Baner::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới slide thành công!'
        ]);
    }

    public function destroy($id)
    {
        Baner::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá slide thành công!'
        ]);
    }

    public function update(Request $request)
    {
        $data   = $request->all();

        Baner::find($request->id)->update($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật slide thành công!'
        ]);
    }
    public function doiTrangThai(Request $request)
    {
        $slide = Baner::find($request->id);
        if ($slide) {
            if ($slide->tinh_trang == 1) {
                $slide->tinh_trang = 0;
            } else {
                $slide->tinh_trang = 1;
            }
            $slide->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái slide thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Đã có lỗi xảy ra!"
            ]);
        }
    }

}
