# Movie Theater Management – Backend

API quản lý rạp chiếu phim  
Phát triển bằng Laravel (PHP) – Chuẩn RESTful API

## 🚀 Mô tả dự án
- Quản lý phim, suất chiếu, phòng chiếu, vé, người dùng với phân quyền rõ ràng (admin, nhân viên, khách hàng).
- Hỗ trợ đặt vé, quản lý đặt vé, thống kê doanh thu.
- Tích hợp xác thực JWT, bảo mật, phân quyền truy cập.
- Thiết kế code rõ ràng, dễ mở rộng, chuẩn PSR-12.

## 🛠️ Công nghệ sử dụng
- Laravel PHP Framework
- Eloquent ORM
- JWT Authentication & Laravel Sanctum
- MySQL/MariaDB (Database)
- RESTful API
- PHPUnit (Unit Test)

## ⚙️ Cài đặt & chạy thử
```bash
git clone https://github.com/Khoa-CNTT/XDHTQLRC7916.git
cd XDHTQLRC7916
composer install
cp .env.example .env
# Thiết lập thông tin database trong .env
php artisan migrate --seed
php artisan serve
```
API mặc định chạy tại: `http://localhost:8000`

## 📚 Chức năng chính (API endpoints)
- Đăng nhập, đăng ký, quên mật khẩu, xác thực email
- CRUD phim, suất chiếu, phòng chiếu, vé
- Đặt vé, huỷ vé, xem lịch sử đặt vé
- Quản lý người dùng, phân quyền
- Thống kê doanh thu, số vé đã bán

## 🏷️ Một số endpoint mẫu
- `POST /api/khach-hang/dang-nhap` – Đăng nhập
- `GET /api/trang-chu/data` – Trang chủ

## 🌐 Liên kết frontend demo
- Demo FE: [https://dzcicema.deloydz.com/](https://dzcicema.deloydz.com/)
