<?php

namespace App\Http\Controllers;

use App\Models\ChiTietTheLoai;
use Illuminate\Http\Request;

class ChiTietTheLoaiController extends Controller
{
    public function getData(){
        $data   =   ChiTietTheLoai::all();

        return response()->json([
            'status'      =>  true,
            'data'  =>  $data
        ]);
    }

    public function store(Request $request)
    {
        $data   =   $request->all();
        ChiTietTheLoai::create($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã tạo mới dịch vụ thành công!'
        ]);
    }

    public function destroy($id)
    {
        ChiTietTheLoai::find($id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã xoá dịch vụ thành công!'
        ]);
    }


    public function update(Request $request)
    {
        $data   = $request->all();

        ChiTietTheLoai::find($request->id)->update($data);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã cập nhật dịch vụ thành công!'
        ]);
    }
}
