<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChucNang;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class ChiTietPhanQuyenController extends Controller
{
    public function getData(Request $request)
    {
        $data = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
            ->join('chuc_nangs', 'chuc_nangs.id', 'chi_tiet_phan_quyens.id_chuc_nang')
            ->where('id_quyen', $request->id_chuc_vu)
            ->select('chi_tiet_phan_quyens.*', 'chuc_vus.ten_chuc_vu', 'chuc_nangs.ten_chuc_nang')
            ->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataCN(Request $request)
    {
        // Lấy danh sách id_chuc_nang của quyền đã có
        $data1 = ChiTietPhanQuyen::where('id_quyen', $request->id)->pluck('id_chuc_nang')->toArray();

        // Lấy danh sách chức năng chưa có trong quyền
        $data = ChucNang::whereNotIn('id', $data1)->get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function timKiemCN(Request $request)
    {
        $noi_dung = '%' . $request->noi_dung . '%';

        // Lấy danh sách id_chuc_nang của quyền đã có
        $data1 = ChiTietPhanQuyen::where('id_quyen', $request->id_chuc_vu)->pluck('id_chuc_nang')->toArray();

        // Lọc các chức năng chưa có trong quyền và tìm kiếm theo tên
        $data = ChucNang::whereNotIn('id', $data1)
            ->where('ten_chuc_nang', 'like', $noi_dung)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function timKiemCQ(Request $request){
        $noi_dung = '%' . $request->noi_dung . '%';
        $data = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
            ->join('chuc_nangs', 'chuc_nangs.id', 'chi_tiet_phan_quyens.id_chuc_nang')
            ->where('id_quyen', $request->id_chuc_vu)
            ->where('chuc_nangs.ten_chuc_nang', 'like', $noi_dung)
            ->select('chi_tiet_phan_quyens.*', 'chuc_vus.ten_chuc_vu', 'chuc_nangs.ten_chuc_nang')
            ->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function capQuyen(Request $request)
    {
        $check = ChiTietPhanQuyen::where('id_quyen', $request->id_quyen)
            ->where('id_chuc_nang', $request->id_chuc_nang)
            ->first();
        if ($check) {
            return response()->json([
                'status' => 0,
                'message' => 'Chức vụ đã có quyền này',
            ]);
        } else {
            ChiTietPhanQuyen::create($request->all());
            return response()->json([
                'status' => 1,
                'message' => 'Cấp quyền thành công',
            ]);
        }
    }
    public function xoaQuyen(Request $request)
    {

        $ten_quyen = ChiTietPhanQuyen::where('id', $request->id)->first();
        if ($ten_quyen) {
            $ten_quyen->delete();
            return response()->json([
                'status' => true,
                'message' => "Đã xóa tên quyền thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có Lỗi"
            ]);
        }
    }
}