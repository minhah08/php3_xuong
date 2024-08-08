@extends('layouts.client')

@section('css')
@endsection

@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">My oder</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                            <div class="myaccount-content">
                                <h5>Thông tin đơn hàng: <span class="text-danger">{{$donHang->ma_don_hang}}</span></h5>
                                <div class="welcome">
                                    <p>Tên người nhận: <strong>{{$donHang->ten_nguoi_nhan}}</strong> <strong>
                                    <p>Email người nhận: <strong>{{$donHang->email_nguoi_nhan}}</strong> <strong>
                                    <p>Số điện thoại người nhận: <strong>{{$donHang->so_dien_thoai_nguoi_nhan}}</strong> <strong>
                                    <p>Địa chỉ người nhận: <strong>{{$donHang->dia_chi_nguoi_nhan}}</strong> <strong>
                                    <p>Ngày đặt hàng: <strong>{{$donHang->created_at->format('d-m-Y')}}</strong> <strong>                               
                                    <p>Ghi chú người nhận: <strong>{{$donHang->ghi_chu}}</strong> <strong>
                                    <p>Trạng thái đơn hàng: <strong>{{$trangThaiDonHang[$donHang->trang_thai_don_hang]}}</strong> <strong>
                                    <p>Trạng thái thanh toán: <strong>{{$trangThaiThanhToan[$donHang->trang_thai_thanh_toan]}}</strong> <strong>
                                    <p>Tổng tiền hàng: <strong>{{number_format($donHang->tien_hang, 0, '', '.')}} VNĐ</strong> <strong>
                                    <p>Tổng tiền ship: <strong>{{number_format($donHang->tien_ship, 0, '', '.')}} VNĐ</strong> <strong>
                                    <p>Tổng tiền hàng: <strong>{{number_format($donHang->tong_tien, 0, '', '.')}} VNĐ</strong> <strong>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                            <div class="myaccount-content">
                                <h5>Sản Phẩm </h5>
                                <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Hình ảnh sản phẩm</th>
                                                <th>Mã sản phẩm</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Đơn giá</th>
                                                <th>Số lượng</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($donHang->chiTietDonHang as $item)
                                            @php
                                                $sanPham = $item->sanPham;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <img class="img-fluid" src="{{ Storage::url($sanPham->hinh_anh) }}" alt="Sản Phẩm" width="75px">
                                                </td>
                                                <td>{{$sanPham->ma_san_pham}}</td>
                                                <td>{{$sanPham->ten_san_pham}}</td>
                                                <td>{{number_format($item->don_gia,0,'','.')}}</td>
                                                <td>{{$item->so_luong}}</td>
                                                <td>{{number_format($item->thanh_tien, 0, '', '.')}}</td>
                                                <td><a href="cart.html" class="btn btn-sqr">View</a>
                                                </td>
                                            </tr>
        
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
    @endsection
