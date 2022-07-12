<table>
    <thead>
    <tr>
        <th>Mã Phiếu Kho</th>
        <th>Mã Đơn Hàng</th>
        <th>Nhà Cung Cấp</th>
        <th>Nhân Viên</th>
        <th>Ngày Tạo</th>
        <th>Trạng Thái</th>
    </tr>
    </thead>
    <tbody>
    @foreach($phieukho as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->maDonHang }}</td>
            <td>{{ $item->nhacungcap->tenNhaCungCap }}</td>
            <td>{{ $item->user->hoTen }}</td>
            <td>{{ date('d-m-Y', strtotime($item->ngayTao)) }}</td>
            <td>
                @if($item->trangThai == 0)  Đang chờ duyệt
                 @elseif ($item->trangThai == 1) Đã thanh toán
                 @else  Đã huỷ
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>