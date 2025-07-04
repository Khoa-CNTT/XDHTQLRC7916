<?php

use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\DichVuController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\SuatChieuController;
use App\Http\Controllers\ChiTietTheLoaiController;
use App\Http\Controllers\ChiTietVeController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\QuanLyPhimController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\GheController;
use App\Http\Controllers\ChiTietPhanQuyenController;
use App\Http\Controllers\TheLoaiController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\LoginGoogleController;
use App\Http\Controllers\ThanhToanController;

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChiTietVeDichVuController;
use App\Http\Controllers\GocDienAnhController;
use App\Http\Controllers\SuKienController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestControllert;
use App\Http\Controllers\ThongKeController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;


Route::get('/auto', [KhachHangController::class, 'getAuto']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




Route::group(['middleware' => 'adminMiddle'], function () {
    Route::get('/khach-hang/data', [KhachHangController::class, 'getData']);
    Route::post('/khach-hang/create', [KhachHangController::class, 'createData']);
    Route::put('/khach-hang/update', [KhachHangController::class, 'updateData']);
    Route::delete('/khach-hang/delete/{id}', [KhachHangController::class, 'deleteData']);
    Route::put('/khach-hang/doi-trang-thai', [KhachHangController::class, 'doiTrangThai']);

    Route::get('/nhan-vien/data', [NhanVienController::class, 'getData']);
    Route::post('/nhan-vien/create', [NhanVienController::class, 'createData']);
    Route::put('/nhan-vien/update', [NhanVienController::class, 'updateData']);
    Route::delete('/nhan-vien/delete/{id}', [NhanVienController::class, 'deleteData']);
    Route::put('/nhan-vien/doi-trang-thai', [NhanVienController::class, 'doiTrangThai']);



    Route::get('/dich-vu/data', [DichVuController::class, 'getData']);
    Route::post('/dich-vu/create', [DichVuController::class, 'createData']);
    Route::put('/dich-vu/update', [DichVuController::class, 'updateData']);
    Route::delete('/dich-vu/delete/{id}', [DichVuController::class, 'deleteData']);
    Route::put('/dich-vu/doi-trang-thai', [DichVuController::class, 'doiTrangThai']);


    Route::get('/danh-gia/data', [DanhGiaController::class, 'getData']);
    Route::post('/danh-gia/create', [DanhGiaController::class, 'createData']);
    Route::put('/danh-gia/update', [DanhGiaController::class, 'updateData']);
    Route::delete('/danh-gia/delete/{id}', [DanhGiaController::class, 'deleteData']);
    Route::put('/danh-gia/doi-trang-thai', [DanhGiaController::class, 'doiTrangThai']);



    Route::get('/chuc-vu/data', [ChucVuController::class, 'getData']);
    Route::get('/chuc-vu/data/open', [ChucVuController::class, 'getDataOP']);
    Route::post('/chuc-vu/create', [ChucVuController::class, 'createData']);
    Route::put('/chuc-vu/update', [ChucVuController::class, 'updateData']);
    Route::delete('/chuc-vu/delete/{id}', [ChucVuController::class, 'deleteData']);
    Route::put('/chuc-vu/doi-trang-thai', [ChucVuController::class, 'doiTrangThai']);
    Route::put('/chuc-vu/doi-master', [ChucVuController::class, 'doiMaster']);

    Route::get('/phong/data', [PhongController::class, 'getData']);
    Route::post('/phong/create', [PhongController::class, 'store']);
    Route::delete('/phong/delete/{id}', [PhongController::class, 'destroy']);
    Route::put('/phong/update', [PhongController::class, 'update']);
    Route::put('/phong/doi-trang-thai', [PhongController::class, 'doiTrangThai']);


    Route::get('/suat-chieu/data', [SuatChieuController::class, 'getData']);
    Route::post('/suat-chieu/create', [SuatChieuController::class, 'store']);
    Route::post('/suat-chieu/create-multiple', [SuatChieuController::class, 'storeMultiple']);
    Route::delete('/suat-chieu/delete/{id}', [SuatChieuController::class, 'destroy']);
    Route::put('/suat-chieu/update', [SuatChieuController::class, 'update']);
    Route::put('/suat-chieu/doi-trang-thai', [SuatChieuController::class, 'doiTrangThai']);
    // API suất chiếu bổ sung
    Route::get('/suat-chieu/so-ghe-trong/{id}', [SuatChieuController::class, 'getSoGheTrong']);
    Route::get('/suat-chieu/cap-nhat-trang-thai-tu-dong', [SuatChieuController::class, 'capNhatTrangThaiTuDong']);
    Route::get('/suat-chieu/open-data', [SuatChieuController::class, 'openData']);
    Route::get('/suat-chieu/lay-phong/{id_phim}', [SuatChieuController::class, 'layPhong']);




    Route::post('/chuc-nang/data', [ChiTietPhanQuyenController::class, 'getDataCN']);
    Route::get('/phan-quyen/quyen', [ChiTietPhanQuyenController::class, 'CheckQuyen']);
    Route::post('/chi-tiet-quyen/data', [ChiTietPhanQuyenController::class, 'getData']);
    Route::post('/chi-tiet-quyen/cap-quyen', [ChiTietPhanQuyenController::class, 'capQuyen']);
    Route::post('/chi-tiet-quyen/xoa-quyen', [ChiTietPhanQuyenController::class, 'xoaQuyen']);
    Route::post('/chi-tiet-quyen/tim-kiem', [ChiTietPhanQuyenController::class, 'timKiemCQ']);
    Route::post('/chuc-nang/tim-kiem', [ChiTietPhanQuyenController::class, 'timKiemCN']);



    Route::get('/chi-tiet-the-loai/data', [ChiTietTheLoaiController::class, 'getData']);
    Route::post('/chi-tiet-the-loai/create', [ChiTietTheLoaiController::class, 'store']);
    Route::delete('/chi-tiet-the-loai/delete/{id}', [ChiTietTheLoaiController::class, 'destroy']);
    Route::put('/chi-tiet-the-loai/update', [ChiTietTheLoaiController::class, 'update']);


    Route::get('/chi-tiet-ve/data', [ChiTietVeController::class, 'getData']);
    Route::post('/chi-tiet-ve/create', [ChiTietVeController::class, 'store']);
    Route::delete('/chi-tiet-ve/delete/{id}', [ChiTietVeController::class, 'destroy']);
    Route::put('/chi-tiet-ve/update', [ChiTietVeController::class, 'update']);

    Route::get('/chi-tiet-ve/kiem-tra-dat-ve', [ChiTietVeController::class, 'kiemTraDatVe']);


    // Quản lý ghế
    Route::get('/ghe/data', [GheController::class, 'getData']);
    Route::get('/ghe/search', [GheController::class, 'search']);
    Route::get('/ghe/theo-phong/{phongId}', [GheController::class, 'getGheTheoPhong']);
    Route::put('/ghe/doi-loai-ghe', [GheController::class, 'doiLoaiGhe']);
    Route::put('/ghe/doi-trang-thai', [GheController::class, 'doiTrangThai']);

    Route::post('/hoa-don/check-in/{ma_hoa_don}', [ThanhToanController::class, 'checkInHoaDon']);
    Route::post('/hoa-don/check-in-dich-vu/{ma_hoa_don}', [ThanhToanController::class, 'checkInDichVu']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::group(['prefix' => '/admin'], function () {
        Route::group(['prefix' => '/quan-ly-phim'], function () {
            Route::get('/lay-du-lieu', [QuanLyPhimController::class, 'getData']);
            Route::post('/tim-quan-ly-phim', [QuanLyPhimController::class, 'searchQuanLyPhim']);
            Route::post('/them-moi-quan-ly-phim', [QuanLyPhimController::class, 'themMoiQuanLyPhim']);
            Route::delete('/xoa-quan-ly-phim/{id}', [QuanLyPhimController::class, 'xoaQuanLyPhim']);
            Route::put('/doi-trang-thai', [QuanLyPhimController::class, 'doiTrangThaiQuanLyPhim']);
            Route::put('/update', [QuanLyPhimController::class, 'createQuanLyPhim']);
        });
        Route::group(['prefix' => '/the-loai-phim'], function () {
            Route::get('/lay-du-lieu', [TheLoaiController::class, 'getData']);
            Route::post('/search', [TheLoaiController::class, 'searchTheLoai']);
            Route::post('/create', [TheLoaiController::class, 'createTheLoai']);
            Route::delete('/delete/{id}', [TheLoaiController::class, 'deleteTheLoai']);
            Route::put('/update', [TheLoaiController::class, 'updateTheLoai']);
        });
        // Thống kê routes
        Route::middleware(['check.chucnang'])->group(function () {
            Route::get('/thong-ke/doanh-thu', [ThongKeController::class, 'thongKeDoanhThu']);
            Route::get('/thong-ke/theo-ngay', [ThongKeController::class, 'thongKeTheoNgay']);
            Route::get('/thong-ke/theo-tuan', [ThongKeController::class, 'thongKeTheoTuan']);
            Route::get('/thong-ke/theo-thang', [ThongKeController::class, 'thongKeTheoThang']);
            Route::get('/thong-ke/theo-quy', [ThongKeController::class, 'thongKeTheoQuy']);
            Route::get('/thong-ke/theo-nam', [ThongKeController::class, 'thongKeTheoNam']);
        });



        // Su kien
        Route::get('/su-kien/data', [SuKienController::class, 'getData']);
        Route::post('/su-kien/create', [SuKienController::class, 'createData']);
        Route::put('/su-kien/update', [SuKienController::class, 'updateData']);
        Route::delete('/su-kien/delete/{id}', [SuKienController::class, 'deleteData']);
        Route::put('/su-kien/doi-trang-thai', [SuKienController::class, 'doiTrangThai']);
    });
});


//api check vé
Route::get('/chi-tiet-ve/data', [ChiTietVeController::class, 'checkVe']);



//client
Route::get('/hoa-don/data', [HoaDonController::class, 'getData']);
Route::get('/hoa-don/quyen', [HoaDonController::class, 'quyen']);
Route::get('/hoa-don/data-client', [HoaDonController::class, 'getDataClient']);
Route::post('/hoa-don/create', [HoaDonController::class, 'create']);
Route::post('/hoa-don/chi-tiet-dat-ve', [HoaDonController::class, 'chiTietDatVe']);

// dang nhap admin
Route::post('/admin/dang-nhap', [NhanVienController::class, 'dangNhap']);
Route::post("/kiem-tra-token-admin", [NhanVienController::class, "kiemTraToken"]);

// dang nhap khách hàng
Route::post('/khach-hang/dang-nhap', [KhachHangController::class, 'dangNhap']);
Route::post("/kiem-tra-token-khach-hang", [KhachHangController::class, "kiemTraToken"]);
Route::post("/khach-hang/dat-lai-mat-khau", [KhachHangController::class, 'datLaiMatKhau']);
Route::post("/khach-hang/quen-mat-khau", [KhachHangController::class, 'quenMatKhau']);
Route::post('/dang-ky', [KhachHangController::class, 'dangKy']);
Route::post("/khach-hang/kich-hoat", [KhachHangController::class, 'kichHoat']);
Route::post("/khach-hang/thong-tin-ca-nhan", [KhachHangController::class, 'thongTinCaNhan']);
Route::post("/khach-hang/doi-mat-khau", [KhachHangController::class, 'doiMatKhau']);
Route::post("/khach-hang/cap-nhat-thong-tin", [KhachHangController::class, 'capNhatThongTin']);
Route::get("/khach-hang/hoa-don", [KhachHangController::class, 'loadHD']);



Route::get('/lay-ve/data', [ChiTietVeController::class, 'getDataOpen']);
Route::get('/lay-ve/data-1/{id}', [ChiTietVeController::class, 'getData1']);
Route::post('/lay-ve/doi-trang-thai-dat', [ChiTietVeController::class, 'chaneStatusDat']);
Route::post('/lay-ve/doi-trang-thai-huy', [ChiTietVeController::class, 'chaneStatusHuy']);
Route::post('/lay-ve/kiem-tra-trang-thai', [ChiTietVeController::class, 'kiemTraTrangThai']);
Route::get('/ghe-client/data/{id}', [ChiTietVeController::class, 'getDataClient']);

Route::post('/trang-chu/data', [TrangChuController::class, 'dataTrangChu']);
Route::post('/trang-chu/phim-sap-chieu/data', [TrangChuController::class, 'dataPhimSapChieu']);

Route::get('/lay-danh-gia/data/{id}', [DanhGiaController::class, 'getDataChiTietPhim']);
Route::get('/lay-dich-vu/data', [DichVuController::class, 'getDataDichVu']);
Route::get('/lay-dich-vu-khuyen-mai/data', [DichVuController::class, 'getDataDichVuKhuyenMai']);
Route::post('/dat-dich-vu', [ChiTietVeDichVuController::class, 'datDichVu']);
Route::post('/huy-dich-vu', [ChiTietVeDichVuController::class, 'huyDichVu']);
Route::post('/tang-dich-vu', [ChiTietVeDichVuController::class, 'tangDichVu']);
Route::post('/giam-dich-vu', [ChiTietVeDichVuController::class, 'giamDichVu']);
Route::get('/danh-sach-dich-vu/{id_suat}', [ChiTietVeDichVuController::class, 'getDanhSachDichVu']);
Route::get('/danh-sach-dich-vu-theo-ve/{id_chi_tiet_ve}', [ChiTietVeDichVuController::class, 'getDanhSachDichVuTheoVe']);




// đặt Suất phía client
Route::get('/lay-suat-chieu/data/{id}', [SuatChieuController::class, 'getDataSuatChieu']);
Route::post('/lay-suat-chieu/open-data/{id}', [SuatChieuController::class, 'openDataSuat']);


Route::get('/phim-chi-tiet/{id}', [QuanLyPhimController::class, 'phimChiTiet']);

Route::get('/slide/data', [SlideController::class, 'getData']);
Route::get('/slide/data-client', [SlideController::class, 'getDataClient']);
Route::post('/slide/create', [SlideController::class, 'store']);
Route::delete('/slide/delete/{id}', [SlideController::class, 'destroy']);
Route::put('/slide/update', [SlideController::class, 'update']);
Route::put('/slide/doi-trang-thai', [SlideController::class, 'doiTrangThai']);


Route::get('khach-hang/dang-xuat', [KhachHangController::class, 'dangXuat']);
Route::get('khach-hang/dang-xuat-all', [KhachHangController::class, 'dangXuatAll']);
Route::post('khach-hang/danh-gia', [DanhGiaController::class, 'danhGia']);
Route::delete('khach-hang/danh-gia/delete/{id}', [DanhGiaController::class, 'deleteDataClient']);
Route::put('khach-hang/danh-gia/update', [DanhGiaController::class, 'updateDataClient']);

Route::get('admin/dang-xuat', [NhanVienController::class, 'dangXuat']);
Route::get('admin/dang-xuat-all', [NhanVienController::class, 'dangXuatAll']);

//login with google


// Thêm route mới để xử lý kết quả thanh toán
Route::post('/thanh-toan/dat-dich-vu', [ThanhToanController::class, 'datDichVu']);
Route::post('/thanh-toan/huy-dich-vu', [ThanhToanController::class, 'huyDichVu']);
Route::post('/thanh-toan', [ThanhToanController::class, 'thanhToan']);
Route::post('/thanh-toan/ket-qua', [ThanhToanController::class, 'ketQuaThanhToan']); // Đổi từ GET sang POST
Route::get('/thanh-toan/ipn', [ThanhToanController::class, 'ipnVnpay']); // Thêm route cho IPN
Route::get('/thanh-toan/chi-tiet-hoa-don/{maHoaDon}', [ThanhToanController::class, 'chiTietHoaDon']);
Route::get('/hoa-don/check-in/{ma_hoa_don}', [ThanhToanController::class, 'checkInHoaDon']);
Route::post('/thanh-toan/tien-mat', [ThanhToanController::class, 'thanhToanTienMat']);

// Chatbot routes
Route::prefix('chatbot')->group(function () {
    Route::post('/query', [TestControllert::class, 'analyzeUserQuery']);
});

Route::prefix('goc-dien-anh')->group(function () {
    Route::get('/data', [GocDienAnhController::class, 'getData']);
    Route::get('/data/open', [GocDienAnhController::class, 'getDataOP']);
    Route::post('/create', [GocDienAnhController::class, 'createData']);
    Route::post('/update', [GocDienAnhController::class, 'updateData']);
    Route::delete('/delete/{id}', [GocDienAnhController::class, 'deleteData']);
    Route::post('/doi-trang-thai', [GocDienAnhController::class, 'doiTrangThai']);
    Route::get('/data-by-id/{id}', [GocDienAnhController::class, 'getDataById']);
});

Route::get('/su-kien/client/data', [SuKienController::class, 'getDataSuKien']);
// Su kien client chi tiet
Route::get('/su-kien/client/chi-tiet/{id}', [SuKienController::class, 'getChiTietSuKien']);

Route::get('/suat-chieu/lay-suat/{id_phim}/{id_phong}', [SuatChieuController::class, 'laySuat']);

Route::get('/chi-tiet-ve/lay-theo-suat/{id_suat}', [ChiTietVeController::class, 'layTheoSuat']);

//kiểm tra admin
