<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNhanVienRequest;
use App\Http\Requests\UpdateNhanVien;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NhanVienController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 10;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', 'chuc_vus.id')
                ->select('nhan_viens.*', 'chuc_vus.ten_chuc_vu')
                ->get();
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
                $data = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', 'chuc_vus.id')
                    ->select('nhan_viens.*', 'chuc_vus.ten_chuc_vu')
                    ->get();
                return response()->json([
                    'data'  =>  $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền '
                ]);
            }
        }
    }
    public function createData(CreateNhanVienRequest $request)
    {
        $id_chuc_nang = 11;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   $request->all();
            $data['password'] = bcrypt($request->password);
            NhanVien::create($data);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã tạo mới nhân viên thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   =   $request->all();
                $data['password'] = bcrypt($request->password);
                NhanVien::create($data);

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã tạo mới nhân viên thành công!'
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
        $id_chuc_nang = 13;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            NhanVien::find($id)->delete();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xoá nhân viên thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                NhanVien::find($id)->delete();

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá nhân viên thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }
    public function updateData(UpdateNhanVien $request)
    {
        $id_chuc_nang = 62;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();

        if ($master->is_master) {
            $data = $request->all();
            // Mã hóa mật khẩu nếu có cập nhật mật khẩu mới
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                // Nếu không cập nhật mật khẩu thì bỏ trường password
                unset($data['password']);
            }

            NhanVien::find($request->id)->update($data);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật nhân viên thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();

            if ($check) {
                $data = $request->all();
                if (!empty($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                } else {
                    unset($data['password']);
                }

                NhanVien::find($request->id)->update($data);
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã cập nhật nhân viên thành công!'
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
        $id_chuc_nang = 14;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $nhan_vien = NhanVien::find($request->id);
            if ($nhan_vien) {
                if ($nhan_vien->tinh_trang == 1) {
                    $nhan_vien->tinh_trang = 0;
                } else {
                    $nhan_vien->tinh_trang = 1;
                }
                $nhan_vien->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi trạng thái nhân viên thành công!"
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
                $nhan_vien = NhanVien::find($request->id);
                if ($nhan_vien) {
                    if ($nhan_vien->tinh_trang == 1) {
                        $nhan_vien->tinh_trang = 0;
                    } else {
                        $nhan_vien->tinh_trang = 1;
                    }
                    $nhan_vien->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái nhân viên thành công!"
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

    // danng nhap
    public function dangNhap(Request $request)
    {

        // $check = NhanVien::where('email',$request->email)
        //                   ->where('password',$request->password)
        //                   ->first();

        // Câu lệnh này cố gắng xác thực người dùng với guard nhan_vien bằng cách kiểm tra email và mật khẩu được cung cấp. Nếu thông tin đăng nhập đúng,
        // người dùng sẽ được xác thực và phương thức attempt sẽ trả về true. Nếu thông tin đăng nhập không đúng, nó sẽ trả về false.
        // khi mật khẩu mã hóa ở database khi người dùng nhập câu lệnh này xác thực người dùng nhập có đúng với mk trước khi mã hóa
        $check  = Auth::guard('nhan_vien')->attempt(['email' => $request->email, 'password' =>  $request->password]);

        if ($check) {
            $user =  Auth::guard('nhan_vien')->user();
            if ($user->tinh_trang == 0) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Tài khoản của bạn đã bị khoá!'
                ]);
            }
            return response()->json([
                'status'        =>  true,
                // tạo token
                'token'         => $user->createToken('token')->plainTextToken,

                'ho_ten_admin'  => $user->ten_nhan_vien,
                'id_nhan_vien'  => $user->id,

                'avatar_admin'  => $user->avatar,
                'message'       =>  'Đã đăng nhập thành công'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Tài Khoản hoặc mật khẩu không đúng'
            ]);
        }
    }

    public function kiemTraToken(Request $request)
    {
        // Lấy thông tin từ Authorization : 'Bearer ' gửi lên
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\NhanVien) {
            return response()->json([
                'status'    =>  true,
                'message'   =>  "Oke, bạn có thể đi qua",
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  "Bạn cần đăng nhập hệ thống trước",
            ]);
        }
    }

    public function dangXuat()
    {
        $user = Auth::guard('sanctum')->user();
        DB::table('personal_access_tokens')->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Bạn đã đăng xuất thành công!',
        ]);
    }

    public function dangXuatAll()
    {
        $user     = Auth::guard('sanctum')->user();
        $ds_token = $user->tokens;

        foreach ($ds_token as $key => $value) {
            $value->delete();
        }

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Bạn đã đăng xuất tất cả thành công!',
        ]);
    }
}
