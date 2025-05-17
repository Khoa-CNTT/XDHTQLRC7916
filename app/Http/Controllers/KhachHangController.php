<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoiMatKhauRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Http\Requests\KhachHangDatLaiMatKhauRequest;
use App\Http\Requests\KhachHangQuenMatKhauRequest;
use App\Http\Requests\KhachHangUpdateRequest;
use App\Http\Requests\KhachHangRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\ChiTietPhanQuyen;
use App\Models\ChucVu;
use App\Models\HoaDon;

class KhachHangController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 5;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   =   KhachHang::all();
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
                $data   =   KhachHang::all();
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
    public function createData(KhachHangRequest $request)
    {
        $id_chuc_nang = 6;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)->first();

        if (
            $master->is_master || ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
            ->where('chuc_vus.tinh_trang', 1)
            ->where('id_quyen', $user->id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->exists()
        ) {
            try {
                $data = $request->all();
                if ($data['password'] !== $data['re_password']) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Mật khẩu nhập lại không khớp!'
                    ], 422);
                }
                if (isset($data['password'])) {
                    $data['password'] = bcrypt($data['password']);
                    $data['re_password'] = $data['password']; // Lưu giống password đã mã hóa
                }

                KhachHang::create($data);

                return response()->json([
                    'status'  => true,
                    'message' => 'Đã tạo mới khách hàng thành công!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Có lỗi xảy ra khi tạo khách hàng!',
                    'error'   => $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status'  => false,
            'message' => 'Bạn không có quyền thực hiện chức năng này!'
        ], 403);
    }

    public function thongTinCaNhan()
    {
        $user = Auth::guard('sanctum')->user();
        return response()->json([
            'data' => $user
        ]);
    }

    public function deleteData($id)
    {
        $id_chuc_nang = 8;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            KhachHang::find($id)->delete();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã xoá Khach Hang thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                KhachHang::find($id)->delete();

                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã xoá Khach Hang thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    public function updateData(KhachHangUpdateRequest $request)
    {
        $id_chuc_nang = 62;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data   = $request->all();
            KhachHang::find($request->id)->update($data);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã cập nhật  thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data   = $request->all();
                KhachHang::find($request->id)->update($data);
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Đã cập nhật thành công!'
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
        $id_chuc_nang = 9;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $khach_hang = KhachHang::find($request->id);
            if ($khach_hang) {
                if ($khach_hang->is_block == 1) {
                    $khach_hang->is_block = 0;
                } else {
                    $khach_hang->is_block = 1;
                }
                $khach_hang->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi tình trạng khách hàng thành công!"
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
                $khach_hang = KhachHang::find($request->id);
                if ($khach_hang) {
                    if ($khach_hang->is_block == 1) {
                        $khach_hang->is_block = 0;
                    } else {
                        $khach_hang->is_block = 1;
                    }
                    $khach_hang->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi tình trạng khách hàng thành công!"
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

    public function dangNhap(Request $request)
    {
        $check  = Auth::guard('khach_hang')->attempt(['email' => $request->email, 'password' =>  $request->password]);
        if ($check) {
            $user =  Auth::guard('khach_hang')->user();
            if ($user->is_block) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Tài khoản của bạn đã bị khoá!'
                ]);
            }
            if ($user->is_active) {
                return response()->json([
                    'status'        =>  true,
                    // tạo token
                    'token'         => $user->createToken('token')->plainTextToken,
                    'ho_ten_khach_hang'  => $user->ten_khach_hang,
                    'id_khach_hang'  => $user->id,
                    'message'       =>  'Đã đăng nhập thành công'
                ]);
            } else {
                Auth::guard('khach_hang')->logout();
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Vui lòng kiểm tra email!'
                ]);
            }
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
        if ($user && $user instanceof \App\Models\KhachHang && $user->is_block==0) {
            return response()->json([
                'status'    =>  true,
                'message'   =>  "Oke, bạn có thể đi qua",
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  "Bạn cần đăng nhập",
            ]);
        }
    }

    public function datLaiMatKhau(KhachHangDatLaiMatKhauRequest $request)
    {
        KhachHang::where('hash_reset', $request->hash_reset)->update([
            'password'      =>  bcrypt($request->password),
            'hash_reset'    =>  null
        ]);

        return response()->json([
            'status'    =>  true,
            'message'   =>  "Đã đặt lại mật khẩu thành công!",
        ]);
    }

    public function doiMatKhau(DoiMatKhauRequest $request)
    {
        $check  = Auth::guard('khach_hang')->attempt(['email' => $request->email, 'password' =>  $request->password]);

        $kh = KhachHang::where('email', $request->email)->first();
        if ($check) {
            $kh['password'] = bcrypt($request->moi);
            $kh->save();
            $ds_token = $kh->tokens;
            foreach ($ds_token as $k => $v) {
                $v->delete();
            }
            return response()->json([
                'status' => true,
                'message' => "Đổi mật khẩu thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Đổi mật khẩu thất bại"
            ]);
        }
    }
    public function quenMatKhau(KhachHangQuenMatKhauRequest $request)
    {
        $hash_reset     =   Str::uuid();
        KhachHang::where('email', $request->email)->update([
            'hash_reset'   =>   $hash_reset
        ]);

        $kh = KhachHang::where('email', $request->email)->first();
        if ($kh) {
            $data['ho_va_ten']  = $kh->ten_khach_hang;
            $data['link']    = "http://localhost:5173/dat-lai-mat-khau/" . $hash_reset;

            // Gửi email tới tài khoản $request->email + $hash_reset
            Mail::to($request->email)->send(new SendMail("Khôi Phục Mật Khẩu", "quen_mat_khau", $data));

            return response()->json([
                'status'    =>  true,
                'message'   =>  "Vui lòng kiểm tra email!",
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  "Email không tồn tại!",
            ]);
        }
    }

    public function dangKy(Request $request)
    {
        $check_mail = KhachHang::where('email', $request->email)->first();
        if ($check_mail) {
            return response()->json([
                'status' => false,
                'message' => "Email đã tồn tại trong hệ thống!"
            ]);
        } else {

            $data                   =   $request->all();
            $data['password']       =   bcrypt($request->password);
            $data['hash_active']    =   Str::uuid();
            KhachHang::create($data);

            $mail['ho_va_ten']      =   $request->ten_khach_hang;
            $mail['link']           =   "http://localhost:5173/kich-hoat/" . $data['hash_active'];

            Mail::to($request->email)->send(new SendMail("Kích hoạt tài khoản", "kich_hoat_tai_khoan", $mail));

            return response()->json([
                'status' => true,
                'message' => "Đăng kí tài khoản thành công!"
            ]);
        }
    }
    public function kichHoat(Request $request)
    {
        $khach_hang = KhachHang::where('hash_active', $request->hash_active)->first();

        if ($khach_hang) {
            $khach_hang->is_active      = 1;
            $khach_hang->hash_active    = null;
            $khach_hang->save();

            return response()->json([
                'status'    =>  true,
                'message'   =>  "Bạn đã kích hoạt tài khoản thành công!",
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  "Mã kích hoạt không tồn tại!",
            ]);
        }
    }

    public function dangXuat()
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if ($khach_hang && $khach_hang instanceof \App\Models\KhachHang) {
            DB::table('personal_access_tokens')
                ->where('id', $khach_hang->currentAccessToken()->id)->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đăng xuất thiết bị này thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }

    public function dangXuatAll()
    {
        $khach_hang = Auth::guard('sanctum')->user();
        if ($khach_hang && $khach_hang instanceof \App\Models\KhachHang) {
            $ds_token = $khach_hang->tokens;
            foreach ($ds_token as $k => $v) {
                $v->delete();
            }

            return response()->json([
                'status' => true,
                'message' => "Đã đăng xuất tất cả thiết bị này thành công"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Vui lòng đăng nhập"
            ]);
        }
    }
    public function loadHD()
    {
        $khach_hang = Auth::guard('sanctum')->user();
        $data = HoaDon::where('id_khach_hang', $khach_hang->id)
            ->where('trang_thai', '1')
            ->get();
        $tong_tien_da_thanh_toan = HoaDon::where('id_khach_hang', $khach_hang->id)
            ->where('trang_thai', '1')
            ->sum('tong_tien');
        return response()->json([
            'data' => $data,
            'tong_tien_da_thanh_toan' => $tong_tien_da_thanh_toan
        ]);
    }

    public function capNhatThongTin(Request $request)
    {
        $data = $request->all();
        $khachHang = KhachHang::find($request->id);

        if (!$khachHang) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy khách hàng!'
            ], 404);
        }

        $khachHang->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhật thành công!'
        ]);
    }
}
