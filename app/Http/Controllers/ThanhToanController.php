<

            // Nếu có hóa đơn pending
            if ($hoaDonPending) {
                // Nếu hóa đơn pending quá 15 phút
                if ($hoaDonPending->created_at <= now()->subMinutes(15)) {
                    // Giải phóng ghế
                    ChiTietVe::where('id_hoa_don', $hoaDonPending->id)
                        ->update([
                            'tinh_trang' => 0,
                            'id_khach_hang' => null,
                            'id_nhan_vien' => null,
                            'id_hoa_don' => null
                        ]);

                    // Hủy hóa đơn
                    $hoaDonPending->trang_thai = 2; // Đã hủy
                    $hoaDonPending->ghi_chu = 'Hóa đơn bị hủy do quá thời gian thanh toán (15 phút)';
                    $hoaDonPending->save();

                    Log::info('Hủy hóa đơn timeout: ' . $hoaDonPending->ma_hoa_don);
                } else {
                    // Nếu hóa đơn vẫn trong thời gian cho phép
                    return response()->json([
                        'status' => false,
                        'message' => 'Bạn có một hóa đơn đang trong quá trình thanh toán. Vui lòng hoàn tất hoặc đợi hệ thống tự hủy sau 15 phút!',
                        'ma_hoa_don' => $hoaDonPending->ma_hoa_don
                    ]);
                }
            }

            if ($user && $user instanceof \App\Models\KhachHang) {
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


            } else {
                // Lấy thông tin vé đã chọn
                $ve = ChiTietVe::where('id_nhan_vien', $user->id)
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
                    'id_nhan_vien' => $user->id,
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
            $checkInUrl = "http://localhost:5173/check-qr?ma_hoa_don={$hoaDon->ma_hoa_don}";

            // Tạo QR code với endroid/qr-code
            $qrCode = QrCode::create($checkInUrl)
                ->setSize(300)
                ->setMargin(10)
                ->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Lấy data URI của QR code cho frontend
            $qrCodeDataUri = $result->getDataUri();

            // Lưu QR code vào file tạm thời để gửi email
            $tempDir = storage_path('app/public/qr_codes');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            $qrFileName = 'qr_' . $hoaDon->ma_hoa_don . '.png';
            $qrFilePath = $tempDir . '/' . $qrFileName;

            // Lưu QR code vào file
            file_put_contents($qrFilePath, $result->getString());

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
                'danh_sach_ve' => $chiTietVes->map(function ($ve) {
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
                'qr_code' => $qrCodeDataUri, // Cho frontend
                'qr_file_path' => $qrFilePath, // Đường dẫn file QR cho email
                'ticket_info' => $groupTicketData
            ];
        } catch (\Exception $e) {
            Log::error('Lỗi tạo QR code: ' . $e->getMessage());

            // Nếu có lỗi, trả về chỉ thông tin vé mà không có QR code
            return [
                'qr_code' => null,
                'qr_file_path' => null,
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

                // Lưu mã QR vào hóa đơn
                $hoaDon->ma_qr_checkin = $qrResult['qr_code'];
                $hoaDon->save();

                // Chuẩn bị dữ liệu cho email
                $danhSachGhe = $chiTietVes->map(function($ve) {
                    return $ve->ghe->ten_ghe;
                })->implode(', ');

                // Lấy thông tin khách hàng
                $khachHang = null;
                if ($hoaDon->id_khach_hang) {
                    $khachHang = \App\Models\KhachHang::find($hoaDon->id_khach_hang);
                }

                if ($khachHang) {
                    $emailData = [
                        'ho_va_ten' => $khachHang->ten_khach_hang,
                        'ma_hoa_don' => $hoaDon->ma_hoa_don,
                        'ten_phim' => $suatChieu->ten_phim,
                        'thoi_gian_chieu' => $suatChieu->ngay_chieu . ' ' . $suatChieu->gio_bat_dau,
                        'phong' => $suatChieu->ten_phong,
                        'danh_sach_ghe' => $danhSachGhe,
                        'tong_tien' => $hoaDon->tong_tien,
                        'qr_code' => $qrResult['qr_code'],
                        'qr_file_path' => $qrResult['qr_file_path']
                    ];

                    // Gửi email xác nhận thanh toán
                    Mail::to($khachHang->email)->send(new SendMail(
                        "Xác nhận thanh toán thành công",
                        "thanh_toan_thanh_cong",
                        $emailData
                    ));
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Thanh toán thành công!',
                    'ma_hoa_don' => $vnp_TxnRef,
                    'thoi_gian_thanh_toan' => Carbon::now()->format('Y-m-d H:i:s'),
                    'qr_code' => $qrResult['qr_code']
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
                'id_nhan_vien' => null,
                'id_hoa_don' => null
            ]);
    }

    public function chiTietHoaDon($maHoaDon)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\KhachHang) {
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
                    'qr_file_path' => $qrResult['qr_file_path'],
                    'chi_tiet_qr' => $qrResult['ticket_info']
                ]
            ]);
        } else {
            // Lấy thông tin hóa đơn
            $hoaDon = HoaDon::where('ma_hoa_don', $maHoaDon)
                ->where('id_nhan_vien', $user->id)
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
