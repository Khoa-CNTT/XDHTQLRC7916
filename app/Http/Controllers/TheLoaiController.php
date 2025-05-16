<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTheLoai;
use App\Http\Requests\UpdateTheLoai;
use App\Models\TheLoai;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TheLoaiController extends Controller
{
    public function getData(){
        $data = TheLoai::all();
        return response()->json([
            'the_loai' => $data,
        ]);
    }
    public function searchTheLoai(Request $request){
        $data = TheLoai::select("id",'ten_the_loai')
        ->where('ten_the_loai', $request->abc)
        ->get();
        return response()->json([
            'the_loai' => $data,
        ]);
    }
    public function createTheLoai(CreateTheLoai $request){
            TheLoai::create([
            'ten_the_loai'       => $request->ten_the_loai,
            'mo_ta'              => $request->mo_ta,

        ]);
        return response()->json([
            'status'            =>   true,
            'message'           =>   'Đã tạo mới Thể Loại thành công!',
        ]);
    }
    public function deleteTheLoai($id){
            TheLoai::find($id)->delete();
            return response()->json([
                'status'            =>   1,
                'message'           =>   'Xóa Thể Loại thành công!',
            ]);
    }
     public function updateTheLoai(UpdateTheLoai $request){
        $data = $request->all();
        TheLoai::find($request->id)->update($data);
        return response()->json([
                    'status' => true,
                    'message' => 'Đã cập nhật thành công Thể Loại',
                ]);
            }
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(TheLoai $theLoai)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(TheLoai $theLoai)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, TheLoai $theLoai)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(TheLoai $theLoai)
    // {
    //     //
    // }
}
