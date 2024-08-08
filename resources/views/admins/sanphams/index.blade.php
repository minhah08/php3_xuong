@extends('layouts.admin')

@section('title')
    {{ $title }}
@endsection

@section('css')
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Quản lý thông tin sản phẩm</h4>
                </div>
            </div>

            <!-- Striped Rows -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title align-content-center mb-0">{{ $title }}</h5>
                        <a href="{{ route('admins.sanphams.create') }}" class="btn btn-success"><i
                                data-feather="plus-square"></i>Thêm mới</a>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{session('success')}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" 
                                    aria-label="Close"></button>
                                </div>             
                            @endif
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã sản phẩm</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Giá sản phẩm</th>
                                        <th scope="col">Giá khuyến mãi</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listSanPham as $index => $item)
                                        <tr>
                                            <th scope="row">{{ $item->ma_san_pham }}</th>
                                            <td><img src="{{ Storage::url($item->hinh_anh) }}" width="100"
                                                    alt=""></td>
                                            <td>{{ $item->ten_san_pham }}</td>
                                            <td>{{ $item->danhMuc->ten_danh_muc }}</td>
                                            <td>{{ number_format($item->gia_san_pham) }}</td>
                                            <td>{{number_format(empty($item->gia_khuyen_mai) ? 0 : $item->gia_khuyen_mai) }}</td>
                                            <td>{{ $item->so_luong }}</td>
                                            <td class="{{ $item->is_type == true ? 'text-success' : 'text-danger' }}">
                                                {{ $item->is_type == true ? 'Hiển thị' : 'Ẩn' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admins.sanphams.edit', $item->id) }}"><i
                                                        class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                                <form action="{{ route('admins.sanphams.destroy', $item->id) }}"
                                                    method="post" class="d-inline" onsubmit="return confirm('Bạn có đồng ý xóa không ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="border-0 bg-white"><i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
@endsection

@section('js')
@endsection
