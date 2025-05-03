<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhanQuyen;
use App\Models\ChiTietVe;
use App\Models\ChucVu;
use App\Models\Ghe;
use App\Models\SuatChieu;
use App\Models\QuanLyPhim;
use App\Models\Phong;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuatChieuController extends Controller
{


    // Lấy tất cả suất chiếu
    public function getData(Request $request)
    {
        $id_chuc_nang = 40;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $data = SuatChieu::with(['phim', 'phong'])->get();

            return response()->json([
                'suat' => $data
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $data = SuatChieu::with(['phim', 'phong'])->get();

                return response()->json([
                    'suat' => $data
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }
    }

    // Lấy suất chiếu theo phòng
    public function openData(Request $request)
    {
        $data = SuatChieu::where('phong_id', $request->id)
            ->get();

        return response()->json([
            'suat' => $data
        ]);
    }

    // Lấy suất chiếu theo phim và ngày
    public function openDataSuat($id, Request $request)
    {
        $data = SuatChieu::with(['phim', 'phong'])
            ->whereDate('ngay_chieu', $request->ngay)
            ->where('phim_id', explode("-", $id)[0])
            ->where('trang_thai', '!=', 'Hủy')
            ->orderBy('gio_bat_dau', 'asc')
            ->get();

        // Nhóm suất chiếu theo định dạng
        $suatChieuTheoDinhDang = $data->groupBy('dinh_dang');

        // Tính số ghế còn trống cho mỗi suất chiếu
        foreach ($data as $suat) {
            $tongSoGhe = Ghe::where('phong_id', $suat->phong_id)->count();
            $soGheDaDat = ChiTietVe::where('id_suat', $suat->id)
                ->where(function ($query) {
                    $query->where('tinh_trang', 1) // Ghế đã đặt
                        ->orWhere('tinh_trang', 2); // Ghế đang giữ
                })
                ->count();
            $suat->so_ghe_trong = $tongSoGhe - $soGheDaDat;
            //tong so ghe
            $suat->tong_so_ghe = $tongSoGhe;
        }

        return response()->json([
            'suat' => $data,
            'suat_theo_dinh_dang' => $suatChieuTheoDinhDang
        ]);
    }

    // Lấy tất cả suất chiếu của một phim
    public function getDataSuatChieu($id)
    {
        $phimId = explode("-", $id)[0];

        // Lấy tất cả suất chiếu của phim
        $data = SuatChieu::where('phim_id', $phimId)
            ->where('trang_thai', '!=', 'Hủy')
            ->where(function ($query) {
                $query->where('ngay_chieu', '>=', date('Y-m-d'))
                    ->orWhere(function ($q) {
                        $q->where('ngay_chieu', '=', date('Y-m-d'))
                            ->where('gio_bat_dau', '>=', date('H:i:s'));
                    });
            })
            ->orderBy('ngay_chieu', 'asc')
            ->orderBy('gio_bat_dau', 'asc')
            ->get();

        // Lấy danh sách ngày chiếu duy nhất
        $ngayChieu = $data->pluck('ngay_chieu')->unique()->values()->all();

        return response()->json([
            'suat' => $data,
            'ngay_chieu' => $ngayChieu
        ]);
    }

    // Tạo suất chiếu mới
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'phim_id' => 'required|exists:quan_ly_phims,id',
            'phong_id' => 'required|exists:phongs,id',
            'ngay_chieu' => 'required|date|after_or_equal:today',
            'gio_bat_dau' => 'required',
            'gia_ve' => 'required|numeric',
            'gia_ve_vip' => 'required|numeric',
            'gia_ve_doi' => 'required|numeric',
            'dinh_dang' => 'required|in:2D,3D,IMAX',
            'ngon_ngu' => 'required|in:Phụ đề,Lồng tiếng,Nguyên bản',
            'trang_thai' => 'required|in:Sắp chiếu,Đang chiếu,Hết vé,Hủy',
        ]);

        // Lấy thông tin phim để tính thời gian kết thúc
        $phim = QuanLyPhim::find($request->phim_id);
        if (!$phim) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy thông tin phim!'
            ]);
        }

        // Tính giờ kết thúc dựa trên thời lượng phim
        $gioBatDau = $request->gio_bat_dau;
        $gioKetThuc = date('H:i:s', strtotime($gioBatDau . ' + ' . $phim->thoi_luong . ' minutes'));

        // Kiểm tra xung đột lịch chiếu trong cùng phòng
        $suatChieuTrung = SuatChieu::where('phong_id', $request->phong_id)
            ->where('ngay_chieu', $request->ngay_chieu)
            ->where(function ($query) use ($gioBatDau, $gioKetThuc) {
                $query->whereBetween('gio_bat_dau', [$gioBatDau, $gioKetThuc])
                    ->orWhereBetween('gio_ket_thuc', [$gioBatDau, $gioKetThuc])
                    ->orWhere(function ($q) use ($gioBatDau, $gioKetThuc) {
                        $q->where('gio_bat_dau', '<=', $gioBatDau)
                            ->where('gio_ket_thuc', '>=', $gioKetThuc);
                    });
            })
            ->exists();

        if ($suatChieuTrung) {
            return response()->json([
                'status' => false,
                'message' => 'Đã có suất chiếu khác trong cùng thời gian và phòng này!'
            ]);
        }

        // Tạo suất chiếu mới
        $data = $request->all();
        $data['gio_ket_thuc'] = $gioKetThuc;

        DB::beginTransaction();
        try {
            // Tạo suất chiếu
            $suat = SuatChieu::create($data);

            // Tạo chi tiết vé cho tất cả ghế trong phòng
            $danhSachGhe = Ghe::where('phong_id', $request->phong_id)->get();
            foreach ($danhSachGhe as $ghe) {
                if($ghe->loai_ghe == 1) {
                    ChiTietVe::create([
                        'id_suat' => $suat->id,
                        'tinh_trang' => 0, // Ghế trống
                        'id_ghe' => $ghe->id,
                        'hoa_don_id' => null,
                        'gia_tien' => $request->gia_ve_vip,
                        'khach_hang_id' => null,
                        'ghi_chu' => null,
                    ]);
                } elseif($ghe->loai_ghe == 2) {
                    ChiTietVe::create([
                        'id_suat' => $suat->id,
                        'tinh_trang' => 0, // Ghế trống
                        'id_ghe' => $ghe->id,
                        'hoa_don_id' => null,
                        'gia_tien' => $request->gia_ve_doi,
                        'khach_hang_id' => null,
                        'ghi_chu' => null,
                    ]);
                } else {
                    ChiTietVe::create([
                        'id_suat' => $suat->id,
                        'tinh_trang' => 0, // Ghế trống
                        'id_ghe' => $ghe->id,
                        'hoa_don_id' => null,
                        'gia_tien' => $request->gia_ve,
                        'khach_hang_id' => null,
                        'ghi_chu' => null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Đã thêm suất chiếu thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ]);
        }
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'danh_sach_suat' => 'required|array',
            'danh_sach_suat.*.phim_id' => 'required|exists:quan_ly_phims,id',
            'danh_sach_suat.*.phong_id' => 'required|exists:phongs,id',
            'danh_sach_suat.*.ngay_chieu' => 'required|date|after_or_equal:today',
            'danh_sach_suat.*.gio_bat_dau' => 'required',
            'danh_sach_suat.*.gia_ve' => 'required|numeric',
            'danh_sach_suat.*.gia_ve_vip' => 'required|numeric',
            'danh_sach_suat.*.gia_ve_doi' => 'required|numeric',
            'danh_sach_suat.*.dinh_dang' => 'required|in:2D,3D,IMAX',
            'danh_sach_suat.*.ngon_ngu' => 'required|in:Phụ đề,Lồng tiếng,Nguyên bản',
            'danh_sach_suat.*.trang_thai' => 'required|in:Sắp chiếu,Đang chiếu,Hết vé,Hủy',
        ]);

        DB::beginTransaction();
        try {
            $suatChieuDaTao = [];
            foreach ($request->danh_sach_suat as $suatData) {
                // Lấy thông tin phim để tính thời gian kết thúc
                $phim = QuanLyPhim::find($suatData['phim_id']);
                if (!$phim) {
                    throw new \Exception('Không tìm thấy thông tin phim!');
                }

                // Tính giờ kết thúc dựa trên thời lượng phim
                $gioBatDau = $suatData['gio_bat_dau'];
                $gioKetThuc = date('H:i:s', strtotime($gioBatDau . ' + ' . $phim->thoi_luong . ' minutes'));

                // Kiểm tra xung đột lịch chiếu trong cùng phòng
                $suatChieuTrung = SuatChieu::where('phong_id', $suatData['phong_id'])
                    ->where('ngay_chieu', $suatData['ngay_chieu'])
                    ->where(function ($query) use ($gioBatDau, $gioKetThuc) {
                        $query->whereBetween('gio_bat_dau', [$gioBatDau, $gioKetThuc])
                            ->orWhereBetween('gio_ket_thuc', [$gioBatDau, $gioKetThuc])
                            ->orWhere(function ($q) use ($gioBatDau, $gioKetThuc) {
                                $q->where('gio_bat_dau', '<=', $gioBatDau)
                                    ->where('gio_ket_thuc', '>=', $gioKetThuc);
                            });
                    })
                    ->exists();

                if ($suatChieuTrung) {
                    throw new \Exception('Đã có suất chiếu khác trong cùng thời gian và phòng này!');
                }

                // Tạo suất chiếu mới
                $suatData['gio_ket_thuc'] = $gioKetThuc;
                $suat = SuatChieu::create($suatData);

                // Tạo chi tiết vé cho tất cả ghế trong phòng
                $danhSachGhe = Ghe::where('phong_id', $suatData['phong_id'])->get();
                foreach ($danhSachGhe as $ghe) {
                    if($ghe->loai_ghe == 1) {
                        ChiTietVe::create([
                            'id_suat' => $suat->id,
                            'tinh_trang' => 0, // Ghế trống
                            'id_ghe' => $ghe->id,
                            'hoa_don_id' => null,
                            'gia_tien' => $suatData['gia_ve_vip'],
                            'khach_hang_id' => null,
                            'ghi_chu' => null,
                        ]);
                    } elseif($ghe->loai_ghe == 2) {
                        ChiTietVe::create([
                            'id_suat' => $suat->id,
                            'tinh_trang' => 0, // Ghế trống
                            'id_ghe' => $ghe->id,
                            'hoa_don_id' => null,
                            'gia_tien' => $suatData['gia_ve_doi'],
                            'khach_hang_id' => null,
                            'ghi_chu' => null,
                        ]);
                    } else {
                        ChiTietVe::create([
                            'id_suat' => $suat->id,
                            'tinh_trang' => 0, // Ghế trống
                            'id_ghe' => $ghe->id,
                            'hoa_don_id' => null,
                            'gia_tien' => $suatData['gia_ve'],
                            'khach_hang_id' => null,
                            'ghi_chu' => null,
                        ]);
                    }
                }

                $suatChieuDaTao[] = $suat;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Đã thêm ' . count($suatChieuDaTao) . ' suất chiếu thành công!',
                'suat_chieu' => $suatChieuDaTao
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ]);
        }
    }

    // Xóa suất chiếu
    public function destroy($id)
    {
        $id_chuc_nang = 43;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $daCoNguoiDat = ChiTietVe::where('id_suat', $id)
                ->where('tinh_trang', 1)
                ->exists();

            if ($daCoNguoiDat) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể xóa suất chiếu đã có người đặt vé!'
                ]);
            }

            // Xóa chi tiết vé trước
            ChiTietVe::where('id_suat', $id)->delete();

            // Xóa suất chiếu
            SuatChieu::find($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Đã xoá suất chiếu thành công!'
            ]);
        } else {
            $check = ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
                ->where('chuc_vus.tinh_trang', 1)
                ->where('id_quyen', $user->id_chuc_vu)
                ->where('id_chuc_nang', $id_chuc_nang)
                ->first();
            if ($check) {
                $daCoNguoiDat = ChiTietVe::where('id_suat', $id)
                    ->where('tinh_trang', 1)
                    ->exists();

                if ($daCoNguoiDat) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Không thể xóa suất chiếu đã có người đặt vé!'
                    ]);
                }

                // Xóa chi tiết vé trước
                ChiTietVe::where('id_suat', $id)->delete();

                // Xóa suất chiếu
                SuatChieu::find($id)->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Đã xoá suất chiếu thành công!'
                ]);
            } else {
                return response()->json([
                    "message" => 'bạn không có quyền này'
                ]);
            }
        }

        // Kiểm tra xem suất chiếu đã có người đặt vé chưa

    }

    // Cập nhật suất chiếu
    public function update(Request $request)
    {
        $id_chuc_nang = 69;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master || ChiTietPhanQuyen::join('chuc_vus', 'chuc_vus.id', 'chi_tiet_phan_quyens.id_quyen')
            ->where('chuc_vus.tinh_trang', 1)
            ->where('id_quyen', $user->id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->exists()) {

            // Kiểm tra xem suất chiếu đã có người đặt vé chưa
            $daCoNguoiDat = ChiTietVe::where('id_suat', $request->id)
                ->where('tinh_trang', 1)
                ->exists();

            $suatChieu = SuatChieu::find($request->id);
            if (!$suatChieu) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy suất chiếu!'
                ]);
            }

            if ($daCoNguoiDat) {
                // Nếu đã có người đặt vé, chỉ cho phép cập nhật giá vé và trạng thái
                $suatChieu->gia_ve = $request->gia_ve;
                $suatChieu->gia_ve_vip = $request->gia_ve_vip;
                $suatChieu->gia_ve_doi = $request->gia_ve_doi;
                $suatChieu->trang_thai = $request->trang_thai;
                $suatChieu->save();

                // Cập nhật giá vé trong chi tiết vé
                $chiTietVes = ChiTietVe::where('id_suat', $request->id)->get();
                foreach ($chiTietVes as $chiTietVe) {
                    $ghe = Ghe::find($chiTietVe->id_ghe);
                    if ($ghe) {
                        if ($ghe->loai_ghe == 1) {
                            $chiTietVe->gia_tien = $request->gia_ve_vip;
                        } elseif ($ghe->loai_ghe == 2) {
                            $chiTietVe->gia_tien = $request->gia_ve_doi;
                        } else {
                            $chiTietVe->gia_tien = $request->gia_ve;
                        }
                        $chiTietVe->save();
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Đã cập nhật giá vé và trạng thái suất chiếu!'
                ]);
            }

            // Nếu chưa có ai đặt vé, cho phép cập nhật đầy đủ
            // Tính lại thời gian kết thúc nếu thay đổi phim hoặc thời gian bắt đầu
            if ($request->phim_id != $suatChieu->phim_id || $request->gio_bat_dau != $suatChieu->gio_bat_dau) {
                $phim = QuanLyPhim::find($request->phim_id);
                $gioBatDau = $request->gio_bat_dau;
                $gioKetThuc = date('H:i:s', strtotime($gioBatDau . ' + ' . $phim->thoi_luong . ' minutes'));

                // Kiểm tra xung đột lịch chiếu
                $suatChieuTrung = SuatChieu::where('phong_id', $request->phong_id)
                    ->where('ngay_chieu', $request->ngay_chieu)
                    ->where('id', '!=', $request->id)
                    ->where(function ($query) use ($gioBatDau, $gioKetThuc) {
                        $query->whereBetween('gio_bat_dau', [$gioBatDau, $gioKetThuc])
                            ->orWhereBetween('gio_ket_thuc', [$gioBatDau, $gioKetThuc])
                            ->orWhere(function ($q) use ($gioBatDau, $gioKetThuc) {
                                $q->where('gio_bat_dau', '<=', $gioBatDau)
                                    ->where('gio_ket_thuc', '>=', $gioKetThuc);
                            });
                    })
                    ->exists();

                if ($suatChieuTrung) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Đã có suất chiếu khác trong cùng thời gian và phòng này!'
                    ]);
                }

                $request->merge(['gio_ket_thuc' => $gioKetThuc]);
            }

            $data = $request->all();
            $suatChieu->update($data);

            // Cập nhật giá vé trong chi tiết vé
            $chiTietVes = ChiTietVe::where('id_suat', $request->id)->get();
            foreach ($chiTietVes as $chiTietVe) {
                $ghe = Ghe::find($chiTietVe->id_ghe);
                if ($ghe) {
                    if ($ghe->loai_ghe == 1) {
                        $chiTietVe->gia_tien = $request->gia_ve_vip;
                    } elseif ($ghe->loai_ghe == 2) {
                        $chiTietVe->gia_tien = $request->gia_ve_doi;
                    } else {
                        $chiTietVe->gia_tien = $request->gia_ve;
                    }
                    $chiTietVe->save();
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật suất chiếu thành công!'
            ]);
        } else {
            return response()->json([
                "message" => 'bạn không có quyền này'
            ]);
        }
    }

    // Đổi trạng thái suất chiếu
    public function doiTrangThai(Request $request)
    {
        $id_chuc_nang = 44;
        $user = Auth::guard('sanctum')->user();
        $master = ChucVu::where('id', $user->id_chuc_vu)
            ->first();
        if ($master->is_master) {
            $suat = SuatChieu::find($request->id);
            if ($suat) {
                // Kiểm tra nếu suất chiếu đã bắt đầu và có người đặt vé
                $daCoNguoiDat = ChiTietVe::where('id_suat', $request->id)
                    ->where('tinh_trang', 1)
                    ->exists();

                $daQua = Carbon::now() > Carbon::parse($suat->thoi_gian_bat_dau);

                if ($daQua && $daCoNguoiDat && $suat->tinh_trang == 1) {
                    return response()->json([
                        'status' => false,
                        'message' => "Không thể hủy suất chiếu đã bắt đầu và có người đặt vé!"
                    ]);
                }

                if ($suat->tinh_trang == 1) {
                    $suat->tinh_trang = 0;
                } else {
                    $suat->tinh_trang = 1;
                }
                $suat->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đổi trạng thái suất chiếu thành công!"
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
                $suat = SuatChieu::find($request->id);
                if ($suat) {
                    // Kiểm tra nếu suất chiếu đã bắt đầu và có người đặt vé
                    $daCoNguoiDat = ChiTietVe::where('id_suat', $request->id)
                        ->where('tinh_trang', 1)
                        ->exists();

                    $daQua = Carbon::now() > Carbon::parse($suat->thoi_gian_bat_dau);

                    if ($daQua && $daCoNguoiDat && $suat->tinh_trang == 1) {
                        return response()->json([
                            'status' => false,
                            'message' => "Không thể hủy suất chiếu đã bắt đầu và có người đặt vé!"
                        ]);
                    }

                    if ($suat->tinh_trang == 1) {
                        $suat->tinh_trang = 0;
                    } else {
                        $suat->tinh_trang = 1;
                    }
                    $suat->save();

                    return response()->json([
                        'status' => true,
                        'message' => "Đổi trạng thái suất chiếu thành công!"
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

    // Cập nhật trạng thái suất chiếu tự động (có thể chạy bằng cron job)
    public function capNhatTrangThaiTuDong()
    {
        // Cập nhật suất chiếu đã qua ngày thành 'Đã chiếu'
        SuatChieu::where('ngay_chieu', '<', date('Y-m-d'))
            ->where('trang_thai', '!=', 'Đã chiếu')
            ->where('trang_thai', '!=', 'Hủy')
            ->update(['trang_thai' => 'Đã chiếu']);

        // Cập nhật suất chiếu trong ngày đã qua giờ kết thúc thành 'Đã chiếu'
        SuatChieu::where('ngay_chieu', '=', date('Y-m-d'))
            ->where('gio_ket_thuc', '<', date('H:i:s'))
            ->where('trang_thai', '!=', 'Đã chiếu')
            ->where('trang_thai', '!=', 'Hủy')
            ->update(['trang_thai' => 'Đã chiếu']);

        // Cập nhật suất chiếu trong ngày đã qua giờ bắt đầu thành 'Đang chiếu'
        SuatChieu::where('ngay_chieu', '=', date('Y-m-d'))
            ->where('gio_bat_dau', '<=', date('H:i:s'))
            ->where('gio_ket_thuc', '>', date('H:i:s'))
            ->where('trang_thai', '!=', 'Đang chiếu')
            ->where('trang_thai', '!=', 'Hủy')
            ->update(['trang_thai' => 'Đang chiếu']);

        return response()->json([
            'status' => true,
            'message' => 'Đã cập nhật trạng thái suất chiếu tự động!'
        ]);
    }

    // Lấy số ghế còn trống của suất chiếu
    public function getSoGheTrong($id)
    {
        $suatChieu = SuatChieu::find($id);
        if (!$suatChieu) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy suất chiếu!'
            ]);
        }

        $tongSoGhe = Ghe::where('phong_id', $suatChieu->phong_id)->count();
        // Đếm số ghế đã đặt (có trong hóa đơn hợp lệ)
        $soGheDaDat = ChiTietVe::where('id_suat', $id)
            ->where(function ($query) {
                $query->where('tinh_trang', 1) // Ghế đã đặt
                    ->orWhere('tinh_trang', 2); // Ghế đang giữ
            })
            ->count();

        return response()->json([
            'status' => true,
            'tong_so_ghe' => $tongSoGhe,
            'so_ghe_da_dat' => $soGheDaDat,
            'so_ghe_trong' => $tongSoGhe - $soGheDaDat
        ]);
    }

    public function layPhong($id_phim)
    {
        try {
            $phong = Phong::join('suat_chieus', 'phongs.id', '=', 'suat_chieus.phong_id')
                         ->where('suat_chieus.phim_id', $id_phim)
                         ->where('phongs.tinh_trang', 1)
                         ->select('phongs.*')
                         ->distinct()
                         ->get();

            return response()->json([
                'status'    => true,
                'phong'     => $phong
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra khi lấy danh sách phòng!',
                'error'     => $e->getMessage()
            ]);
        }
    }

    public function laySuat($id_phim, $id_phong)
    {
        try {
            // Query không có filter ngày giờ để debug
            $suat = SuatChieu::where('phim_id', $id_phim)
                            ->where('phong_id', $id_phong)
                            ->where('trang_thai', '!=', 'Hủy')
                            ->orderBy('ngay_chieu', 'asc')
                            ->orderBy('gio_bat_dau', 'asc')
                            ->get();

            // Lấy SQL query để debug
            $sql = SuatChieu::where('phim_id', $id_phim)
                            ->where('phong_id', $id_phong)
                            ->where('trang_thai', '!=', 'Hủy')
                            ->orderBy('ngay_chieu', 'asc')
                            ->orderBy('gio_bat_dau', 'asc')
                            ->toSql();

            return response()->json([
                'status'    => true,
                'suat'      => $suat,
                'debug'     => [
                    'sql'          => $sql,
                    'phim_id'      => $id_phim,
                    'phong_id'     => $id_phong,
                    'raw_data'     => SuatChieu::where('phim_id', $id_phim)->get(),
                    'date_check'   => [
                        'current_date' => date('Y-m-d'),
                        'current_time' => date('H:i:s'),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'message'   => 'Đã có lỗi xảy ra khi lấy danh sách suất chiếu!',
                'error'     => $e->getMessage()
            ]);
        }
    }
}
