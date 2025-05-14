<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGocDienAnhRequest;
use App\Http\Requests\UpdateGocDienAnhRequest;
use App\Models\GocDienAnh;
use Illuminate\Http\Request;

class GocDienAnhController extends Controller
{
    public function getData()
    {
        $data = GocDienAnh::orderBy('ngay_dang', 'desc')->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function createData(CreateGocDienAnhRequest $request)
    {
        $data = $request->all();
        $data['ngay_dang'] = now();

        GocDienAnh::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Đã tạo mới góc điện ảnh thành công!'
        ]);
    }

    public function updateData(UpdateGocDienAnhRequest $request)
    {
        $gocDienAnh = GocDienAnh::find($request->id);

        if (!$gocDienAnh) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy góc điện ảnh!'
            ]);
        }

        $data = $request->except('id'); // Bỏ id ra khỏi dữ liệu cập nhật
        $gocDienAnh->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhật góc điện ảnh thành công!'
        ]);
    }


    public function deleteData($id)
    {
        GocDienAnh::find($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đã xoá góc điện ảnh thành công!'
        ]);
    }

    public function doiTrangThai(Request $request)
    {
        $goc_dien_anh = GocDienAnh::find($request->id);
        if ($goc_dien_anh) {
            $goc_dien_anh->trang_thai = !$goc_dien_anh->trang_thai;
            $goc_dien_anh->save();

            return response()->json([
                'status' => true,
                'message' => "Đổi trạng thái góc điện ảnh thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Đã có lỗi xảy ra!"
            ]);
        }
    }

    public function getDataById($id)
    {
        $goc_dien_anh = GocDienAnh::find($id);

        if ($goc_dien_anh) {
            return response()->json([
                'status' => true,
                'data' => $goc_dien_anh
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy thông tin góc điện ảnh!'
        ]);
    }
}
