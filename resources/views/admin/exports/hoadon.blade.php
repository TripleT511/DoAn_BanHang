<table style="font-family: 'Roboto', sans-serif;">
    <thead>
    <tr>
        <th>Mã Đơn Hàng</th>
        <th>Nhân Viên</th>
        <th>Tên Khách Hàng</th>
        <th>Địa Chỉ</th>
        <th>Email</th>
        <th>Số Điện Thoại</th>
        <th>Ngày Xuất Hoá Đơn</th>
        <th>Tổng Tiền</th>
        <th>Giảm Giá</th>
        <th>Tổng Thành Tiền</th>
        <th>Ghi Chú</th>
        <th>Trạng Thái Thanh Toán</th>
        <th>Trạng Thái Hoá Đơn</th>
    </tr>
    </thead>
    <tbody>
    @foreach($hoadon as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>
                @if($item->user)
                 {{ $item->user->hoTen }}
                @endif
            </td>
            <td>{{ $item->hoTen }}</td>
            <td>{{ $item->diaChi }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->soDienThoai }}</td>
            <td>{{ date('d-m-Y', strtotime($item->ngayXuatHD)) }}</td>
            <td>{{ $item->tongTien }}</td>
            <td>{{ $item->giamGia }}</td>
            <td>{{ $item->tongThanhTien }}</td>
            <td>{{ $item->ghiChu }}</td>
            <td>
                @if($item->trangThaiThanhToan == 0) Chưa thanh toán
                @elseif($item->trangThaiThanhToan == 1)Đã thanh toán
                @endif
            </td>
            <td>
                @if($item->trangThai == 0) Chờ xác nhận
                @elseif($item->trangThai == 1)Đã xác nhận
                @elseif($item->trangThai == 2) Chờ giao hàng
                @elseif($item->trangThai == 3) Đang giao hàng
                @elseif($item->trangThai == 4) Hoàn thành
                @elseif($item->trangThai == 5) Đã huỷ
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>