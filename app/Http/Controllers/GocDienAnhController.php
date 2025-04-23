<?php

namespace App\Http\Controllers;

use App\Models\GocDienAnh;
use Illuminate\Http\Request;

class GocDienAnhController extends Controller
{
    public function getData()
    {
        $data = GocDienAnh::all();
        return response()->json($data);
    }

    public function createData(Request $request)
    {
        $data = GocDienAnh::create($request->all());
        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $data = GocDienAnh::find($request->id);
        $data->update($request->all());
        return response()->json($data);
    }

    public function deleteData($id)
    {
        GocDienAnh::find($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function doiTrangThai(Request $request)
    {
        $data = GocDienAnh::find($request->id);
        $data->trang_thai = !$data->trang_thai;
        $data->save();
        return response()->json($data);
    }
}
