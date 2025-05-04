<template>
  <div class="thong-ke-container">
    <div class="header">
      <h2 class="title">Thống Kê Doanh Thu</h2>
    </div>
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card">
          <div class="card-header">
            <h4>Doanh Thu Theo Tháng</h4>
          </div>
          <div class="card-body">
            <div class="chart-wrapper">
              <Bar v-if="doanhThuLoaded"
                   :data="doanhThuData"
                   :options="doanhThuOptions" />
              <div v-else class="loading">Đang tải dữ liệu...</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Phương Thức Thanh Toán</h4>
          </div>
          <div class="card-body">
            <div class="chart-wrapper">
              <Pie v-if="thanhToanLoaded"
                   :data="thanhToanData"
                   :options="thanhToanOptions" />
              <div v-else class="loading">Đang tải dữ liệu...</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Bar, Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ArcElement
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ArcElement
)

export default {
  name: 'ThongKePage',
  components: {
    Bar,
    Pie
  },
  data() {
    return {
      doanhThuLoaded: false,
      thanhToanLoaded: false,
      doanhThuData: null,
      thanhToanData: null,
      doanhThuOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Doanh Thu Theo Tháng',
            font: {
              size: 16
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return new Intl.NumberFormat('vi-VN', {
                  style: 'currency',
                  currency: 'VND'
                }).format(value);
              }
            }
          }
        }
      },
      thanhToanOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'right',
          },
          title: {
            display: true,
            text: 'Phân Bố Phương Thức Thanh Toán',
            font: {
              size: 16
            }
          }
        }
      }
    }
  },
  async mounted() {
    await this.loadDoanhThuData();
    await this.loadThanhToanData();
  },
  methods: {
    async loadDoanhThuData() {
      try {
        const response = await fetch('/api/thong-ke/doanh-thu');
        const data = await response.json();
        this.doanhThuData = data;
        this.doanhThuLoaded = true;
      } catch (error) {
        console.error('Error loading doanh thu data:', error);
      }
    },
    async loadThanhToanData() {
      try {
        const response = await fetch('/api/thong-ke/thanh-toan');
        const data = await response.json();
        this.thanhToanData = data;
        this.thanhToanLoaded = true;
      } catch (error) {
        console.error('Error loading thanh toan data:', error);
      }
    }
  }
}
</script>

<style scoped>
.thong-ke-container {
  padding: 20px;
  background-color: #f8f9fa;
  min-height: 100vh;
}

.header {
  margin-bottom: 2rem;
}

.title {
  color: #2c3e50;
  font-weight: 600;
  margin: 0;
  padding-bottom: 1rem;
  border-bottom: 2px solid #e9ecef;
}

.card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  margin-bottom: 1.5rem;
}

.card-header {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e9ecef;
}

.card-header h4 {
  margin: 0;
  color: #495057;
  font-weight: 500;
}

.card-body {
  padding: 1.5rem;
}

.chart-wrapper {
  position: relative;
  height: 400px;
  width: 100%;
}

.loading {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  font-size: 1.2em;
  color: #6c757d;
}

@media (max-width: 768px) {
  .chart-wrapper {
    height: 300px;
  }

  .card-body {
    padding: 1rem;
  }
}
</style>
