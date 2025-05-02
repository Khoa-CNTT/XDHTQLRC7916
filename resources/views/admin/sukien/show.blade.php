@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết Sự kiện</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sukien.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.sukien.edit', $suKien) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px">ID</th>
                                    <td>{{ $suKien->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên sự kiện</th>
                                    <td>{{ $suKien->ten_su_kien }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày bắt đầu</th>
                                    <td>{{ $suKien->ngay_bat_dau }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày kết thúc</th>
                                    <td>{{ $suKien->ngay_ket_thuc }}</td>
                                </tr>
                                <tr>
                                    <th>Mô tả</th>
                                    <td>{{ $suKien->mo_ta }}</td>
                                </tr>
                                <tr>
                                    <th>URL Hình ảnh</th>
                                    <td><a href="{{ $suKien->hinh_anh }}" target="_blank">{{ $suKien->hinh_anh }}</a></td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo</th>
                                    <td>{{ $suKien->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối</th>
                                    <td>{{ $suKien->updated_at }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            @if($suKien->hinh_anh)
                                <div class="text-center">
                                    <img src="{{ $suKien->hinh_anh }}"
                                         alt="{{ $suKien->ten_su_kien }}"
                                         class="img-fluid">
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Không có hình ảnh
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
