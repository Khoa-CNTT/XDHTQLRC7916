# Hướng Dẫn Chi Tiết Giải Đề Phỏng Vấn

## Đề 1: Hệ thống Quản lý Sinh viên

### 1. Cài đặt môi trường

#### Frontend (Vue.js)
```bash
# Tạo project Vue.js
vue create student-management
cd student-management

# Cài đặt các dependencies
npm install axios vuex vue-router element-ui
```

#### Backend (Laravel)
```bash
# Tạo project Laravel
composer create-project laravel/laravel student-api
cd student-api

# Cài đặt Laravel Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 2. Cấu trúc Database

```sql
-- Tạo migrations trong Laravel
php artisan make:migration create_classes_table
php artisan make:migration create_students_table

-- Nội dung migration cho bảng classes
public function up()
{
    Schema::create('classes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}

-- Nội dung migration cho bảng students
public function up()
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->foreignId('class_id')->constrained();
        $table->timestamps();
    });
}
```

### 3. Backend Implementation

#### Models
```php
// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'class_id'];

    public function class()
    {
        return $this->belongsTo(Class::class);
    }
}

// app/Models/Class.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Class extends Model
{
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
```

#### Controllers
```php
// app/Http/Controllers/StudentController.php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::with('class')->paginate(10);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'class_id' => 'required|exists:classes,id'
        ]);

        return Student::create($validated);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'class_id' => 'required|exists:classes,id'
        ]);

        $student->update($validated);
        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }
}
```

### 4. Frontend Implementation

#### Vuex Store
```javascript
// store/index.js
import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    students: [],
    classes: [],
    loading: false,
    error: null
  },
  mutations: {
    SET_STUDENTS(state, students) {
      state.students = students
    },
    SET_CLASSES(state, classes) {
      state.classes = classes
    },
    SET_LOADING(state, loading) {
      state.loading = loading
    },
    SET_ERROR(state, error) {
      state.error = error
    }
  },
  actions: {
    async fetchStudents({ commit }) {
      commit('SET_LOADING', true)
      try {
        const response = await axios.get('/api/students')
        commit('SET_STUDENTS', response.data.data)
      } catch (error) {
        commit('SET_ERROR', error.message)
      } finally {
        commit('SET_LOADING', false)
      }
    }
  }
})
```

#### Components
```vue
<!-- components/StudentList.vue -->
<template>
  <div class="student-list">
    <el-table :data="students" v-loading="loading">
      <el-table-column prop="name" label="Tên"></el-table-column>
      <el-table-column prop="email" label="Email"></el-table-column>
      <el-table-column prop="class.name" label="Lớp"></el-table-column>
      <el-table-column label="Thao tác">
        <template slot-scope="scope">
          <el-button @click="editStudent(scope.row)">Sửa</el-button>
          <el-button @click="deleteStudent(scope.row)" type="danger">Xóa</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'StudentList',
  computed: {
    ...mapState(['students', 'loading'])
  },
  methods: {
    ...mapActions(['fetchStudents']),
    editStudent(student) {
      this.$router.push(`/students/${student.id}/edit`)
    },
    async deleteStudent(student) {
      try {
        await this.$confirm('Bạn có chắc muốn xóa sinh viên này?')
        await this.$store.dispatch('deleteStudent', student.id)
        this.$message.success('Xóa thành công')
      } catch (error) {
        if (error !== 'cancel') {
          this.$message.error('Có lỗi xảy ra')
        }
      }
    }
  },
  created() {
    this.fetchStudents()
  }
}
</script>
```

## Đề 2: Hệ thống Đặt hàng Online

### 1. Database Schema

```sql
-- Tạo migrations
php artisan make:migration create_products_table
php artisan make:migration create_orders_table
php artisan make:migration create_order_items_table

-- Products migration
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 10, 2);
        $table->integer('stock');
        $table->timestamps();
    });
}

-- Orders migration
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->decimal('total_amount', 10, 2);
        $table->string('status');
        $table->timestamps();
    });
}

-- Order Items migration
public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained();
        $table->foreignId('product_id')->constrained();
        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->timestamps();
    });
}
```

### 2. Backend Implementation

#### Models
```php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_amount', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

#### Controllers
```php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => 0,
            'status' => 'pending'
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price
            ]);
            $total += $product->price * $item['quantity'];
        }

        $order->update(['total_amount' => $total]);
        return $order->load('items');
    }

    public function exportPdf(Order $order)
    {
        $pdf = PDF::loadView('orders.pdf', ['order' => $order]);
        return $pdf->download('order-' . $order->id . '.pdf');
    }
}
```

### 3. Frontend Implementation

#### Vuex Store
```javascript
// store/index.js
export default new Vuex.Store({
  state: {
    cart: [],
    products: []
  },
  mutations: {
    ADD_TO_CART(state, product) {
      const existing = state.cart.find(item => item.id === product.id)
      if (existing) {
        existing.quantity++
      } else {
        state.cart.push({
          ...product,
          quantity: 1
        })
      }
    },
    REMOVE_FROM_CART(state, productId) {
      state.cart = state.cart.filter(item => item.id !== productId)
    }
  },
  actions: {
    async checkout({ state, commit }) {
      try {
        const response = await axios.post('/api/orders', {
          items: state.cart.map(item => ({
            product_id: item.id,
            quantity: item.quantity
          }))
        })
        commit('CLEAR_CART')
        return response.data
      } catch (error) {
        throw error
      }
    }
  }
})
```

#### Components
```vue
<!-- components/Cart.vue -->
<template>
  <div class="cart">
    <h2>Giỏ hàng</h2>
    <el-table :data="cart">
      <el-table-column prop="name" label="Sản phẩm"></el-table-column>
      <el-table-column prop="price" label="Giá"></el-table-column>
      <el-table-column prop="quantity" label="Số lượng">
        <template slot-scope="scope">
          <el-input-number 
            v-model="scope.row.quantity"
            :min="1"
            @change="updateQuantity(scope.row)"
          ></el-input-number>
        </template>
      </el-table-column>
      <el-table-column label="Tổng">
        <template slot-scope="scope">
          {{ scope.row.price * scope.row.quantity }}
        </template>
      </el-table-column>
      <el-table-column label="Thao tác">
        <template slot-scope="scope">
          <el-button 
            type="danger"
            @click="removeFromCart(scope.row)"
          >Xóa</el-button>
        </template>
      </el-table-column>
    </el-table>
    <div class="cart-total">
      Tổng cộng: {{ total }}
    </div>
    <el-button 
      type="primary"
      @click="checkout"
      :loading="loading"
    >Thanh toán</el-button>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Cart',
  computed: {
    ...mapState(['cart']),
    total() {
      return this.cart.reduce((sum, item) => {
        return sum + (item.price * item.quantity)
      }, 0)
    }
  },
  methods: {
    ...mapActions(['checkout']),
    async handleCheckout() {
      try {
        await this.checkout()
        this.$message.success('Đặt hàng thành công')
        this.$router.push('/orders')
      } catch (error) {
        this.$message.error('Có lỗi xảy ra')
      }
    }
  }
}
</script>
```

## Đề 3: Tối ưu hóa Performance

### 1. Frontend Optimization

#### Lazy Loading Components
```javascript
// router/index.js
const routes = [
  {
    path: '/products',
    component: () => import('@/views/Products.vue')
  },
  {
    path: '/orders',
    component: () => import('@/views/Orders.vue')
  }
]
```

#### Image Optimization
```vue
<!-- components/ProductImage.vue -->
<template>
  <img 
    :src="optimizedImageUrl"
    :alt="alt"
    loading="lazy"
  >
</template>

<script>
export default {
  props: {
    imageUrl: String,
    alt: String
  },
  computed: {
    optimizedImageUrl() {
      // Sử dụng CDN hoặc image optimization service
      return this.imageUrl.replace('original', 'optimized')
    }
  }
}
</script>
```

### 2. Backend Optimization

#### Redis Caching
```php
// app/Http/Controllers/ProductController.php
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        return Cache::remember('products', 3600, function () {
            return Product::with('category')->get();
        });
    }
}
```

#### Query Optimization
```php
// app/Models/Order.php
public function scopeWithDetails($query)
{
    return $query->with([
        'items.product',
        'user',
        'items' => function ($query) {
            $query->select('id', 'order_id', 'product_id', 'quantity', 'price');
        }
    ]);
}
```

## Đề 4: Authentication và Authorization

### 1. JWT Implementation

```php
// config/jwt.php
return [
    'secret' => env('JWT_SECRET'),
    'ttl' => 60 * 24, // 24 hours
    'refresh_ttl' => 60 * 24 * 7, // 7 days
];

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
```

### 2. Role Middleware

```php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
```

## Đề 5: Real-time Chat Application

### 1. WebSocket Setup

```php
// config/websockets.php
return [
    'apps' => [
        [
            'id' => env('PUSHER_APP_ID'),
            'name' => env('APP_NAME'),
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
        ],
    ],
];

// app/Events/NewMessage.php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }
}
```

### 2. Frontend Implementation

```vue
<!-- components/Chat.vue -->
<template>
  <div class="chat">
    <div class="messages" ref="messages">
      <div v-for="message in messages" :key="message.id" class="message">
        <div class="message-header">
          <span class="username">{{ message.user.name }}</span>
          <span class="time">{{ formatTime(message.created_at) }}</span>
        </div>
        <div class="message-content">
          {{ message.content }}
        </div>
      </div>
    </div>
    <div class="input-area">
      <el-input
        v-model="newMessage"
        @keyup.enter="sendMessage"
        placeholder="Nhập tin nhắn..."
      ></el-input>
      <el-button @click="sendMessage">Gửi</el-button>
    </div>
  </div>
</template>

<script>
import Echo from 'laravel-echo'

export default {
  data() {
    return {
      messages: [],
      newMessage: '',
      echo: null
    }
  },
  mounted() {
    this.initializeEcho()
    this.fetchMessages()
  },
  methods: {
    initializeEcho() {
      this.echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.VUE_APP_PUSHER_KEY,
        cluster: process.env.VUE_APP_PUSHER_CLUSTER,
        forceTLS: true
      })

      this.echo.channel('chat')
        .listen('NewMessage', (e) => {
          this.messages.push(e.message)
          this.scrollToBottom()
        })
    },
    async sendMessage() {
      if (!this.newMessage.trim()) return

      try {
        await axios.post('/api/messages', {
          content: this.newMessage
        })
        this.newMessage = ''
      } catch (error) {
        this.$message.error('Không thể gửi tin nhắn')
      }
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.messages
        container.scrollTop = container.scrollHeight
      })
    }
  }
}
</script>
```

## Lưu ý quan trọng:

1. **Security**:
   - Luôn validate input
   - Sử dụng CSRF protection
   - Implement rate limiting
   - Sanitize output

2. **Error Handling**:
   - Implement try-catch blocks
   - Log errors appropriately
   - Return meaningful error messages

3. **Testing**:
   - Write unit tests
   - Implement integration tests
   - Test edge cases

4. **Documentation**:
   - Comment code
   - Document API endpoints
   - Maintain README files

5. **Performance**:
   - Use caching where appropriate
   - Optimize database queries
   - Implement pagination
   - Use lazy loading 
