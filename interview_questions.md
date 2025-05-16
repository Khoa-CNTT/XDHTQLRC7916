# Mẫu Đề Phỏng Vấn Intern/Fresher Fullstack Developer (Vue.js + Laravel)

## Đề 1: Xây dựng Hệ thống Quản lý Sinh viên

### Yêu cầu:
1. Frontend (Vue.js):
   - Tạo form thêm/sửa/xóa sinh viên
   - Hiển thị danh sách sinh viên với phân trang
   - Tìm kiếm và lọc sinh viên theo tên, lớp
   - Sử dụng Vuex để quản lý state
   - Sử dụng Vue Router cho navigation

2. Backend (Laravel):
   - Tạo RESTful API endpoints
   - Sử dụng Laravel Resource Controllers
   - Implement Repository Pattern
   - Validation và Error Handling
   - Authentication với Laravel Sanctum

### Hướng dẫn chi tiết:
1. Cài đặt môi trường:
```bash
# Frontend
vue create student-management
cd student-management
npm install axios vuex vue-router

# Backend
composer create-project laravel/laravel student-api
cd student-api
composer require laravel/sanctum
```

2. Database Schema:
```sql
CREATE TABLE students (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    class_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE classes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

3. API Endpoints cần implement:
- GET /api/students
- POST /api/students
- PUT /api/students/{id}
- DELETE /api/students/{id}
- GET /api/classes

### Thời gian: 90 phút

## Đề 2: Xây dựng Hệ thống Đặt hàng Online

### Yêu cầu:
1. Frontend (Vue.js):
   - Trang danh sách sản phẩm với giỏ hàng
   - Trang chi tiết sản phẩm
   - Trang thanh toán
   - Sử dụng Vuex cho quản lý giỏ hàng
   - Responsive design

2. Backend (Laravel):
   - API quản lý sản phẩm và đơn hàng
   - Xử lý thanh toán
   - Quản lý inventory
   - Export đơn hàng ra PDF

### Hướng dẫn chi tiết:
1. Database Schema:
```sql
CREATE TABLE products (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    price DECIMAL(10,2),
    stock INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    total_amount DECIMAL(10,2),
    status VARCHAR(50),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE order_items (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT,
    product_id BIGINT,
    quantity INT,
    price DECIMAL(10,2)
);
```

2. Các tính năng cần implement:
- Thêm sản phẩm vào giỏ hàng
- Cập nhật số lượng
- Tính tổng tiền
- Tạo đơn hàng
- Xuất PDF đơn hàng

### Thời gian: 120 phút

## Đề 3: Tối ưu hóa Performance

### Yêu cầu:
1. Frontend:
   - Implement lazy loading cho components
   - Tối ưu hóa images
   - Implement caching
   - Code splitting

2. Backend:
   - Query optimization
   - Caching với Redis
   - Eager loading relationships
   - API response optimization

### Hướng dẫn chi tiết:
1. Cài đặt Redis:
```bash
composer require predis/predis
```

2. Các điểm cần tối ưu:
- Sử dụng Vue.lazy() cho components
- Implement Redis cache cho API responses
- Sử dụng eager loading trong Laravel
- Tối ưu hóa database queries

### Thời gian: 60 phút

## Đề 4: Authentication và Authorization

### Yêu cầu:
1. Frontend:
   - Login/Register forms
   - Protected routes
   - Role-based access control
   - Remember me functionality

2. Backend:
   - JWT authentication
   - Role và Permission system
   - Password reset
   - Email verification

### Hướng dẫn chi tiết:
1. Cài đặt packages:
```bash
composer require tymon/jwt-auth
```

2. Implement các tính năng:
- JWT token generation và validation
- Role middleware
- Password reset flow
- Email verification

### Thời gian: 90 phút

## Đề 5: Real-time Chat Application

### Yêu cầu:
1. Frontend:
   - Chat interface
   - Real-time message updates
   - Online/offline status
   - Message notifications

2. Backend:
   - WebSocket implementation
   - Message broadcasting
   - Message persistence
   - User presence system

### Hướng dẫn chi tiết:
1. Cài đặt Laravel WebSockets:
```bash
composer require beyondcode/laravel-websockets
```

2. Database Schema:
```sql
CREATE TABLE messages (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    sender_id BIGINT,
    receiver_id BIGINT,
    content TEXT,
    read_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE user_presence (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    status VARCHAR(50),
    last_seen TIMESTAMP
);
```

3. Implement các tính năng:
- WebSocket connection
- Message broadcasting
- User presence tracking
- Message persistence

### Thời gian: 120 phút

## Lưu ý chung:
- Code phải tuân thủ PSR-12 cho PHP
- Vue.js components phải tuân thủ Vue.js style guide
- Sử dụng TypeScript cho Vue.js (khuyến khích)
- Implement unit tests cho cả frontend và backend
- Sử dụng Git để quản lý code
- Comment đầy đủ cho các functions và components
- Xử lý error handling và validation
- Implement logging system
- Tối ưu hóa performance
- Security best practices
