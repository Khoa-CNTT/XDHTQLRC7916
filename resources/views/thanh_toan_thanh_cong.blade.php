<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="vi">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Thanh toán thành công</title>
    <style type="text/css">
        body {
            font-family: arial, 'helvetica neue', helvetica, sans-serif;
            color: #333333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #e31837;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 30px;
        }
        .ticket-info {
            background-color: #fff5f5;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border: 1px solid #ffebeb;
        }
        .ticket-info h3 {
            color: #e31837;
            margin-top: 0;
            border-bottom: 2px solid #e31837;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .ticket-info p {
            margin: 8px 0;
            line-height: 1.6;
        }
        .qr-section {
            margin: 30px auto;
            max-width: 500px;
            padding: 0;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .qr-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        .qr-header h5 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .qr-content {
            padding: 30px;
            text-align: center;
        }
        .qr-code-container {
            position: relative;
            display: inline-block;
            margin: 15px 0;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .qr-code-container img {
            max-width: 250px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .qr-message {
            color: #333333;
            margin: 15px 0;
            font-size: 16px;
        }
        .qr-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333333;
            color: #ffffff;
        }
        .footer p {
            margin: 5px 0;
            font-size: 12px;
            opacity: 0.8;
        }
        .important-note {
            background-color: #e31837;
            color: #ffffff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>THANH TOÁN THÀNH CÔNG</h1>
        </div>

        <div class="content">
            <p><strong>Xin chào {{ $data['ho_va_ten'] }},</strong></p>
            <p>Cảm ơn bạn đã đặt vé tại rạp phim của chúng tôi. Đơn hàng của bạn đã được thanh toán thành công!</p>

            <div class="ticket-info">
                <h3>Thông tin đơn hàng</h3>
                <p><strong>Mã hóa đơn:</strong> {{ $data['ma_hoa_don'] }}</p>
                <p><strong>Phim:</strong> {{ $data['ten_phim'] }}</p>
                <p><strong>Suất chiếu:</strong> {{ $data['thoi_gian_chieu'] }}</p>
                <p><strong>Phòng:</strong> {{ $data['phong'] }}</p>
                <p><strong>Số ghế:</strong> {{ $data['danh_sach_ghe'] }}</p>
                <p><strong>Tổng tiền:</strong> {{ number_format($data['tong_tien'], 0, ',', '.') }} VNĐ</p>
            </div>

            <div class="qr-section">
                <div class="qr-header">
                    <h5><i class="fas fa-qrcode"></i> Mã QR vé</h5>
                </div>
                <div class="qr-content">
                    <p class="qr-message">Vui lòng trình mã QR tại rạp khi xem phim</p>
                    @if(!empty($data['qr_file_path']) && file_exists($data['qr_file_path']))
                        <div class="qr-code-container">
                            <img src="{{ $message->embed($data['qr_file_path']) }}"
                                 alt="QR Code"
                                 style="max-width: 250px; width: 100%; height: auto;">
                        </div>
                    @else
                        <div class="qr-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            QR code chưa được tạo hoặc hóa đơn chưa thanh toán
                        </div>
                    @endif
                </div>
            </div>

            <div class="important-note">
                Vui lòng đến rạp trước giờ chiếu 30 phút để check-in
            </div>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
            <p>© 2024 Rạp Phim. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
