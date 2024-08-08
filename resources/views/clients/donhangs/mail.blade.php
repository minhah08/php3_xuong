<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .email-container {
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .order-details {
            margin-top: 20px;
        }

        .order-details th,
        .order-details td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Đơn hàng của bạn đã được xác nhận. Dưới đây là chi tiết đơn hàng của bạn:</p>

        <div class="order-details">
            <table>
                <tr>
                    <th>Số đơn hàng:</th>
                    <td>{{ $donHang->ma_don_hang }}</td>
                </tr>
                <tr>
                    <th>Sản phẩm:</th>
                    @foreach ($donHang->chiTietDonHang as $chiTiet)
                        <td>{{ $chiTiet->sanPham->ten_san_pham }} x {{ $chiTiet->so_luong }}: {{ number_format($chiTiet->thanh_tien) }} VND</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Tổng tiền:</th>
                    <td>{{ number_format($donHang->tong_tien) }} VND</td>
                </tr>
                <tr>
                    <th>Địa chỉ giao hàng:</th>
                    <td>{{ $donHang->dia_chi_nguoi_nhan }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email này.</p>
            <p>Cảm ơn bạn đã mua sắm </p>
        </div>
    </div>
</body>

</html>
