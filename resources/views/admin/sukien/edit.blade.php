@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa Sự kiện</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sukien.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sukien.update', $suKien) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="ten_su_kien">Tên sự kiện <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('ten_su_kien') is-invalid @enderror"
                                   id="ten_su_kien"
                                   name="ten_su_kien"
                                   value="{{ old('ten_su_kien', $suKien->ten_su_kien) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control @error('ngay_bat_dau') is-invalid @enderror"
                                   id="ngay_bat_dau"
                                   name="ngay_bat_dau"
                                   value="{{ old('ngay_bat_dau', $suKien->ngay_bat_dau) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
                                   id="ngay_ket_thuc"
                                   name="ngay_ket_thuc"
                                   value="{{ old('ngay_ket_thuc', $suKien->ngay_ket_thuc) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="mo_ta">Mô tả <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror"
                                      id="mo_ta"
                                      name="mo_ta"
                                      rows="4"
                                      required>{{ old('mo_ta', $suKien->mo_ta) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="hinh_anh">URL Hình ảnh <span class="text-danger">*</span></label>
                            @if($suKien->hinh_anh)
                                <div class="mb-2">
                                    <img src="{{ $suKien->hinh_anh }}"
                                         alt="{{ $suKien->ten_su_kien }}"
                                         style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="url"
                                   class="form-control @error('hinh_anh') is-invalid @enderror"
                                   id="hinh_anh"
                                   name="hinh_anh"
                                   value="{{ old('hinh_anh', $suKien->hinh_anh) }}"
                                   placeholder="https://example.com/image.jpg"
                                   required>
                            <small class="form-text text-muted">Nhập URL của hình ảnh (ví dụ: https://example.com/image.jpg)</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validate end date is after start date
    document.getElementById('ngay_ket_thuc').addEventListener('change', function() {
        var startDate = document.getElementById('ngay_bat_dau').value;
        var endDate = this.value;

        if(startDate && endDate && endDate < startDate) {
            alert('Ngày kết thúc phải sau ngày bắt đầu');
            this.value = '';
        }
    });
});
</script>
@endpush
