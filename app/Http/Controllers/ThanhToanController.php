<?php

namespace App\Http\Controllers;

use App\Models\ChiTietVe;
use App\Models\ChiTietVeDichVu;
use App\Models\HoaDon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

class ThanhToanController extends Controller
{
    public function thanhToan(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            // Lấy thông tin vé đã chọn
            $ve = ChiTietVe::where('id_khach_hang', $user->id)
                ->where('id_suat', $request->id_suat)
                ->where('tinh_trang', 1)
                ->get();

            if ($ve->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy vé đã chọn!'
                ]);
            }

            $tongTien = $request->tong_tien;

            // Tạo mã hóa đơn
            $maHoaDon = 'HD' . Str::random(8);

            // Tạo hóa đơn mới
            $hoaDon = HoaDon::create([
                'ma_hoa_don' => $maHoaDon,
                'id_khach_hang' => $user->id,
                'id_suat' => $request->id_suat,
                'tong_tien' => $tongTien,
                'phuong_thuc_thanh_toan' => $request->phuong_thuc_thanh_toan,
                'trang_thai' => 0, // Chờ thanh toán
                'ngay_thanh_toan' => null,
                'ghi_chu' => 'Đặt vé xem phim'
            ]);

            // Cập nhật id_hoa_don cho các chi tiết vé
            foreach ($ve as $chiTietVe) {
                $chiTietVe->id_hoa_don = $hoaDon->id;
                $chiTietVe->save();
            }

            if ($request->phuong_thuc_thanh_toan === 'VNPAY') {
                // Cấu hình VNPay
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://localhost:5173/thanh-toan/ket-qua";
                $vnp_TmnCode = "APORNBE5"; // Lấy từ .env
                $vnp_HashSecret = "1YPXRN7GRJHWCT3I8LPZ0K7GP9RVFSM8"; // Lấy từ .env
                $vnp_TxnRef = $maHoaDon; // Mã đơn hàng
                $vnp_OrderInfo = "Thanh toan ve xem phim";
                $vnp_OrderType = "other";
                $vnp_Amount = $tongTien * 100; // Số tiền * 100
                $vnp_Locale = "vn";
                $vnp_IpAddr = request()->ip();

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                return response()->json([
                    'status' => true,
                    'payment_url' => $vnp_Url,
                    'ma_hoa_don' => $maHoaDon
                ]);
            } else {
                // Xử lý thanh toán tiền mặt
                $hoaDon->trang_thai = 1; // Đã thanh toán
                $hoaDon->ngay_thanh_toan = Carbon::now();
                $hoaDon->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Thanh toán tiền mặt thành công!',
                    'ma_hoa_don' => $maHoaDon
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    private function generateGroupTicketQRData($hoaDon, $chiTietVes, $suatChieu)
    {
        try {
            if ($chiTietVes->isEmpty()) {
                throw new \Exception('Không tìm thấy vé trong hóa đơn');
            }

            if (!$suatChieu) {
                throw new \Exception('Không tìm thấy thông tin suất chiếu');
            }

            // Chỉ tạo QR code cho URL check-in
            $checkInUrl = url("/api/hoa-don/check-in/{$hoaDon->ma_hoa_don}");

            // Tạo QR code với endroid/qr-code
            $qrCode = QrCode::create($checkInUrl)
                ->setSize(300)
                ->setMargin(10)
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Lấy data URI của QR code
            $qrCodeDataUri = $result->getDataUri();

            // Tạo một mảng chứa thông tin của tất cả các vé
            $groupTicketData = [
                'ma_hoa_don' => $hoaDon->ma_hoa_don,
                'id_suat' => $suatChieu->id,
                'id_phong' => $suatChieu->phong_id,
                'ten_phong' => $suatChieu->ten_phong,
                'id_phim' => $suatChieu->phim_id,
                'ten_phim' => $suatChieu->ten_phim,
                'thoi_gian' => $suatChieu->ngay_chieu . ' ' . $suatChieu->gio_bat_dau,
                'so_luong_ve' => $chiTietVes->count(),
                'tong_tien' => $hoaDon->tong_tien,
                'check_in_url' => $checkInUrl,
                'danh_sach_ve' => $chiTietVes->map(function($ve) {
                    if (!$ve->ghe) {
                        throw new \Exception('Không tìm thấy thông tin ghế cho vé: ' . $ve->id);
                    }
                    return [
                        'id_ve' => $ve->id,
                        'id_ghe' => $ve->id_ghe,
                        'ten_ghe' => $ve->ghe->ten_ghe,
                        'loai_ghe' => $ve->ghe->loai_ghe ?? 'Thường',
                        'gia_ve' => $ve->gia_ve
                    ];
                })->toArray()
            ];

            return [
                'qr_code' => $qrCodeDataUri,
                'ticket_info' => $groupTicketData
            ];

        } catch (\Exception $e) {
            Log::error('Lỗi tạo QR code: ' . $e->getMessage());

            // Nếu có lỗi, trả về chỉ thông tin vé mà không có QR code
            return [
                'qr_code' => null,
                'ticket_info' => $groupTicketData ?? []
            ];
        }
    }

    public function ketQuaThanhToan(Request $request)
    {
        try {
            $vnp_ResponseCode = $request->vnp_ResponseCode;
            $vnp_TxnRef = $request->vnp_TxnRef;
            $vnp_Amount = $request->vnp_Amount;
            $vnp_TransactionNo = $request->vnp_TransactionNo;
            $vnp_BankCode = $request->vnp_BankCode;

            // Kiểm tra mã hóa đơn có tồn tại
            $hoaDon = HoaDon::where('ma_hoa_don', $vnp_TxnRef)->first();
            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ]);
            }

            // Kiểm tra trạng thái hóa đơn
            if ($hoaDon->trang_thai == 1) {
                return response()->json([
                    'status' => true,
                    'message' => 'Hóa đơn này đã được thanh toán!',
                    'ma_hoa_don' => $vnp_TxnRef
                ]);
            }

            // Xử lý kết quả thanh toán
            if ($vnp_ResponseCode == "00") {
                // Kiểm tra số tiền thanh toán
                if ($hoaDon->tong_tien * 100 != $vnp_Amount) {
                    $hoaDon->trang_thai = 2; // Đánh dấu hóa đơn thất bại
                    $hoaDon->ghi_chu = 'Số tiền thanh toán không khớp';
                    $hoaDon->save();

                    // Giải phóng ghế
                    $this->giaiPhongGhe($hoaDon->id);

                    return response()->json([
                        'status' => false,
                        'message' => 'Số tiền thanh toán không hợp lệ!'
                    ]);
                }

                // Cập nhật trạng thái hóa đơn
                $hoaDon->trang_thai = 1; // Đã thanh toán
                $hoaDon->ngay_thanh_toan = Carbon::now();
                $hoaDon->ghi_chu = 'Thanh toán thành công qua VNPay. Mã giao dịch: ' . $vnp_TransactionNo . ' - Ngân hàng: ' . $vnp_BankCode;
                $hoaDon->save();

                // Cập nhật trạng thái vé
                ChiTietVe::where('id_hoa_don', $hoaDon->id)
                    ->where('tinh_trang', 1)  // Chỉ cập nhật các vé đang chờ thanh toán
                    ->update([
                        'tinh_trang' => 2  // Đã thanh toán
                    ]);

                // Get suất chiếu details
                $suatChieu = DB::table('suat_chieus')
                    ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id')
                    ->join('phongs', 'suat_chieus.phong_id', '=', 'phongs.id')
                    ->where('suat_chieus.id', $hoaDon->id_suat)
                    ->select(
                        'suat_chieus.*',
                        'quan_ly_phims.id as phim_id',
                        'quan_ly_phims.ten_phim',
                        'phongs.id as phong_id',
                        'phongs.ten_phong'
                    )
                    ->first();

                // Lấy tất cả vé trong hóa đơn
                $chiTietVes = ChiTietVe::with(['ghe'])
                    ->where('id_hoa_don', $hoaDon->id)
                    ->get();

                if ($chiTietVes->isEmpty()) {
                    throw new \Exception('Không tìm thấy vé trong hóa đơn');
                }

                // Tạo một QR code duy nhất cho tất cả các vé
                $qrResult = $this->generateGroupTicketQRData($hoaDon, $chiTietVes, $suatChieu);

                return response()->json([
                    'status' => true,
                    'message' => 'Thanh toán thành công!',
                    'ma_hoa_don' => $vnp_TxnRef,
                    'thoi_gian_thanh_toan' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tickets' => [
                        'thong_tin_ve' => $chiTietVes,
                        'qr_code' => $qrResult['qr_code'],
                        'qr_code_type' => 'data-url',
                        'so_luong_ve' => $chiTietVes->count(),
                        'tong_tien' => $hoaDon->tong_tien,
                        'chi_tiet' => $qrResult['ticket_info']
                    ]
                ]);
            } else {
                // Xử lý thanh toán thất bại
                $hoaDon->trang_thai = 2; // Đã hủy
                $hoaDon->ghi_chu = 'Thanh toán thất bại qua VNPay. Mã lỗi: ' . $vnp_ResponseCode;
                $hoaDon->save();

                // Giải phóng ghế
                $this->giaiPhongGhe($hoaDon->id);

                return response()->json([
                    'status' => false,
                    'message' => 'Thanh toán thất bại! Vui lòng thử lại.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý thanh toán: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cập nhật hàm giải phóng ghế
    private function giaiPhongGhe($hoaDonId)
    {
        ChiTietVe::where('id_hoa_don', $hoaDonId)
            ->update([
                'tinh_trang' => 0,  // Đặt lại trạng thái thành chưa đặt
                'id_khach_hang' => null,
                'id_hoa_don' => null
            ]);
    }

    public function chiTietHoaDon($maHoaDon)
    {
        $user = Auth::guard('sanctum')->user();

        // Lấy thông tin hóa đơn
        $hoaDon = HoaDon::where('ma_hoa_don', $maHoaDon)
            ->where('id_khach_hang', $user->id)
            ->first();

        if (!$hoaDon) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy hóa đơn!'
            ]);
        }

        // Lấy thông tin chi tiết vé
        $chiTietVes = ChiTietVe::join('ghes', 'chi_tiet_ves.id_ghe', 'ghes.id')
            ->where('chi_tiet_ves.id_hoa_don', $hoaDon->id)
            ->select(
                'chi_tiet_ves.*',
                'ghes.ten_ghe',
                'ghes.hang',
                'ghes.cot',
                'ghes.loai_ghe'
            )
            ->get();

        // Lấy thông tin suất chiếu và phim
        $suatChieu = DB::table('suat_chieus')
            ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id')
            ->join('phongs', 'suat_chieus.phong_id', '=', 'phongs.id')
            ->where('suat_chieus.id', $hoaDon->id_suat)
            ->select(
                'suat_chieus.*',
                'quan_ly_phims.ten_phim',
                'quan_ly_phims.hinh_anh',
                'phongs.ten_phong',
                'phongs.id as phong_id',
                'quan_ly_phims.id as phim_id'
            )
            ->first();

        // Tạo QR code cho hóa đơn
        $qrResult = $this->generateGroupTicketQRData($hoaDon, $chiTietVes, $suatChieu);

        $chiTietVesDichVu = ChiTietVeDichVu::join('chi_tiet_ves', 'chi_tiet_ve_dich_vus.id_chi_tiet_ve', 'chi_tiet_ves.id')
            ->join('dich_vus', 'chi_tiet_ve_dich_vus.id_dich_vu', 'dich_vus.id')
            ->join('hoa_dons', 'chi_tiet_ves.id_hoa_don', 'hoa_dons.id')
            ->where('hoa_dons.id', $hoaDon->id)
            ->select(
                'chi_tiet_ve_dich_vus.*',
                'dich_vus.*'
            )
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'hoa_don' => [
                    'ma_hoa_don' => $hoaDon->ma_hoa_don,
                    'tong_tien' => $hoaDon->tong_tien,
                    'phuong_thuc_thanh_toan' => $hoaDon->phuong_thuc_thanh_toan,
                    'trang_thai' => $hoaDon->trang_thai,
                    'ngay_thanh_toan' => $hoaDon->ngay_thanh_toan,
                    'ghi_chu' => $hoaDon->ghi_chu
                ],
                'chi_tiet_ves' => $chiTietVes,
                'suat_chieu' => $suatChieu,
                'chi_tiet_ve_dich_vus' => $chiTietVesDichVu,
                'qr_code' => $qrResult['qr_code'],
                'qr_code_type' => 'data-url',
                'chi_tiet_qr' => $qrResult['ticket_info']
            ]
        ]);
    }

    // Hàm xử lý IPN (Instant Payment Notification) từ VNPAY
    public function ipnVnpay(Request $request)
    {
        try {
            $vnp_ResponseCode = $request->vnp_ResponseCode;
            $vnp_TxnRef = $request->vnp_TxnRef;
            $vnp_Amount = $request->vnp_Amount;
            $vnp_TransactionNo = $request->vnp_TransactionNo;
            $vnp_SecureHash = $request->vnp_SecureHash;

            // Xác thực chữ ký từ VNPAY
            $inputData = [];
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_" && $key != "vnp_SecureHash") {
                    $inputData[$key] = $value;
                }
            }
            ksort($inputData);
            $hashData = "";
            $i = 0;
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }
            $vnp_HashSecret = "1YPXRN7GRJHWCT3I8LPZ0K7GP9RVFSM8";
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // Kiểm tra chữ ký hợp lệ
            if ($secureHash != $vnp_SecureHash) {
                return response()->json([
                    'RspCode' => '97',
                    'Message' => 'Invalid signature'
                ]);
            }

            $hoaDon = HoaDon::where('ma_hoa_don', $vnp_TxnRef)->first();
            if (!$hoaDon) {
                return response()->json([
                    'RspCode' => '01',
                    'Message' => 'Order not found'
                ]);
            }

            if ($hoaDon->tong_tien * 100 != $vnp_Amount) {
                return response()->json([
                    'RspCode' => '04',
                    'Message' => 'Invalid amount'
                ]);
            }

            if ($hoaDon->trang_thai != 0) {
                return response()->json([
                    'RspCode' => '02',
                    'Message' => 'Order already processed'
                ]);
            }

            if ($vnp_ResponseCode == "00") {
                $hoaDon->trang_thai = 1;
                $hoaDon->ngay_thanh_toan = Carbon::now();
                $hoaDon->ghi_chu = 'Thanh toán thành công qua VNPay IPN. Mã giao dịch: ' . $vnp_TransactionNo;
                $hoaDon->save();

                // Get suất chiếu details
                $suatChieu = DB::table('suat_chieus')
                    ->join('quan_ly_phims', 'suat_chieus.phim_id', '=', 'quan_ly_phims.id')
                    ->join('phongs', 'suat_chieus.phong_id', '=', 'phongs.id')
                    ->where('suat_chieus.id', $hoaDon->id_suat)
                    ->select(
                        'suat_chieus.*',
                        'quan_ly_phims.id as phim_id',
                        'quan_ly_phims.ten_phim',
                        'phongs.id as phong_id',
                        'phongs.ten_phong'
                    )
                    ->first();

                // Lấy tất cả vé trong hóa đơn
                $chiTietVes = ChiTietVe::with('ghe')
                    ->where('id_hoa_don', $hoaDon->id)
                    ->get();

                foreach ($chiTietVes as $chiTietVe) {
                    $chiTietVe->tinh_trang = 2; // Đánh dấu vé đã thanh toán
                    $chiTietVe->save();
                }

                // Tạo một QR code duy nhất cho tất cả các vé
                $qrResult = $this->generateGroupTicketQRData($hoaDon, $chiTietVes, $suatChieu);

                return response()->json([
                    'RspCode' => '00',
                    'Message' => 'Confirm Success',
                    'tickets' => [
                        'thong_tin_ve' => $chiTietVes,
                        'qr_code' => $qrResult['qr_code'],
                        'qr_code_type' => 'data-url',
                        'so_luong_ve' => $chiTietVes->count(),
                        'tong_tien' => $hoaDon->tong_tien,
                        'chi_tiet' => $qrResult['ticket_info']
                    ]
                ]);
            } else {
                $hoaDon->trang_thai = 2; // Đã hủy
                $hoaDon->ghi_chu = 'Thanh toán thất bại qua VNPay IPN. Mã lỗi: ' . $vnp_ResponseCode;
                $hoaDon->save();

                // Giải phóng các ghế đã đặt
                $this->giaiPhongGhe($hoaDon->id);

                return response()->json([
                    'RspCode' => '00', // Vẫn trả về 00 để VNPAY biết đã nhận thông báo
                    'Message' => 'Confirm Success'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'RspCode' => '99',
                'Message' => 'Unknown error: ' . $e->getMessage()
            ]);
        }
    }

    public function checkInHoaDon($ma_hoa_don)
    {
        try {
            // Tìm hóa đơn
            $hoaDon = HoaDon::where('ma_hoa_don', $ma_hoa_don)->first();

            if (!$hoaDon) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn!'
                ], 404);
            }

            // Kiểm tra trạng thái thanh toán
            if ($hoaDon->trang_thai != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Hóa đơn chưa được thanh toán!'
                ], 400);
            }

            // Lấy tất cả vé trong hóa đơn
            $chiTietVes = ChiTietVe::where('id_hoa_don', $hoaDon->id)->get();

            if ($chiTietVes->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy vé trong hóa đơn!'
                ], 404);
            }

            // Kiểm tra xem có vé nào đã check-in chưa
            $daCheckIn = $chiTietVes->where('checked_in', 1)->count();
            if ($daCheckIn > 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Một số vé trong hóa đơn đã được check-in trước đó!'
                ], 400);
            }

            // Lấy thông tin suất chiếu
            $suatChieu = DB::table('suat_chieus')
                ->where('id', $hoaDon->id_suat)
                ->first();

            if (!$suatChieu) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy thông tin suất chiếu!'
                ], 404);
            }

            // Kiểm tra thời gian check-in
            $now = now()->setTimezone('Asia/Ho_Chi_Minh');

            // Parse thời gian chiếu và chuyển về múi giờ Việt Nam
            $thoiGianChieu = Carbon::parse($suatChieu->ngay_chieu . ' ' . $suatChieu->gio_bat_dau)
                ->setTimezone('Asia/Ho_Chi_Minh');

            // Nếu thời gian chiếu là ngày mai và giờ hiện tại > 18:00, cho phép check-in
            $isNextDayEarlyMorning = false;
            if ($thoiGianChieu->format('Y-m-d') > $now->format('Y-m-d')) {
                if ($thoiGianChieu->format('H:i') < '12:00' && $now->format('H:i') > '18:00') {
                    $isNextDayEarlyMorning = true;
                }
            }

            // Tính thời gian check-in
            $thoiGianBatDauCheckIn = $thoiGianChieu->copy()->subMinutes(30);
            $thoiGianKetThucCheckIn = $thoiGianChieu->copy()->addMinutes(10);

            // Log để debug thời gian
            Log::info('Debug thời gian check-in:', [
                'now' => $now->format('Y-m-d H:i:s'),
                'timezone' => $now->timezone->getName(),
                'thoiGianChieu' => $thoiGianChieu->format('Y-m-d H:i:s'),
                'batDauCheckIn' => $thoiGianBatDauCheckIn->format('Y-m-d H:i:s'),
                'ketThucCheckIn' => $thoiGianKetThucCheckIn->format('Y-m-d H:i:s')
            ]);

            // Kiểm tra thời gian check-in
            $allowCheckIn = $isNextDayEarlyMorning ||
                ($now->format('Y-m-d') === $thoiGianChieu->format('Y-m-d') &&
                $now->between($thoiGianBatDauCheckIn, $thoiGianKetThucCheckIn));

            if (!$allowCheckIn) {
                // Nếu là suất chiếu ngày mai sáng sớm
                if ($thoiGianChieu->format('Y-m-d') > $now->format('Y-m-d') && $thoiGianChieu->format('H:i') < '12:00') {
                    return response()->json([
                        'status' => false,
                        'message' => 'Suất chiếu sáng sớm ngày mai, check-in sẽ mở lúc 18:00 hôm nay',
                        'gio hien tai' => $now->format('H:i'),
                        'debug_time' => [
                            'ngay_gio_hien_tai' => $now->format('Y-m-d H:i:s'),
                            'ngay_gio_chieu' => $thoiGianChieu->format('Y-m-d H:i:s'),
                            'gio_bat_dau_checkin' => $thoiGianBatDauCheckIn->format('H:i'),
                            'gio_ket_thuc_checkin' => $thoiGianKetThucCheckIn->format('H:i'),
                            'timezone' => $now->timezone->getName()
                        ]
                    ], 400);
                }

                if ($now->lt($thoiGianBatDauCheckIn)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Chưa đến thời gian check-in! Check-in sẽ bắt đầu lúc ' . $thoiGianBatDauCheckIn->format('H:i'),
                        'gio hien tai' => $now->format('H:i'),
                        'debug_time' => [
                            'ngay_gio_hien_tai' => $now->format('Y-m-d H:i:s'),
                            'ngay_gio_chieu' => $thoiGianChieu->format('Y-m-d H:i:s'),
                            'gio_bat_dau_checkin' => $thoiGianBatDauCheckIn->format('H:i'),
                            'gio_ket_thuc_checkin' => $thoiGianKetThucCheckIn->format('H:i'),
                            'timezone' => $now->timezone->getName()
                        ]
                    ], 400);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Đã quá thời gian check-in! Thời gian check-in đã kết thúc lúc ' . $thoiGianKetThucCheckIn->format('H:i'),
                        'gio hien tai' => $now->format('H:i'),
                        'debug_time' => [
                            'ngay_gio_hien_tai' => $now->format('Y-m-d H:i:s'),
                            'ngay_gio_chieu' => $thoiGianChieu->format('Y-m-d H:i:s'),
                            'gio_bat_dau_checkin' => $thoiGianBatDauCheckIn->format('H:i'),
                            'gio_ket_thuc_checkin' => $thoiGianKetThucCheckIn->format('H:i'),
                            'timezone' => $now->timezone->getName()
                        ]
                    ], 400);
                }
            }

            // Tiến hành check-in tất cả các vé
            foreach ($chiTietVes as $chiTietVe) {
                $chiTietVe->checked_in = 1;
                $chiTietVe->thoi_gian_check_in = now()->setTimezone('Asia/Ho_Chi_Minh');
                $chiTietVe->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Check-in thành công ' . $chiTietVes->count() . ' vé!',
                'data' => [
                    'ma_hoa_don' => $hoaDon->ma_hoa_don,
                    'so_ve_check_in' => $chiTietVes->count(),
                    'thoi_gian_check_in' => Carbon::now()->format('Y-m-d H:i:s'),
                    'danh_sach_ghe' => $chiTietVes->map(function($ve) {
                        return [
                            'id_ve' => $ve->id,
                            'ten_ghe' => $ve->ghe->ten_ghe ?? 'Unknown'
                        ];
                    })
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Lỗi check-in hóa đơn: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
