@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản lý Sự kiện</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sukien.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm Sự kiện
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sự kiện</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suKiens as $suKien)
                            <tr>
                                <td>{{ $suKien->id }}</td>
                                <td>{{ $suKien->ten_su_kien }}</td>
                                <td>{{ $suKien->ngay_bat_dau }}</td>
                                <td>{{ $suKien->ngay_ket_thuc }}</td>
                                <td>
                                    @if($suKien->hinh_anh)
                                        <img src="{{ $suKien->hinh_anh }}"
                                             alt="{{ $suKien->ten_su_kien }}"
                                             style="max-width: 100px;">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.sukien.show', $suKien) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sukien.edit', $suKien) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sukien.destroy', $suKien) }}"
                                          method="POST"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa sự kiện này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $suKiens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
