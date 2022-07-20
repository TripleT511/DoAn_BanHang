<table class="table">
    <thead>
      <tr>
        <th class="text-left">#</th>
        <th class="text-left">Sản phẩm</th>
        <th class="text-right">Tổng số lượng</th>
        <th class="text-right">Tổng thành tiền</th>
        <th class="text-right">Tổng đơn hàng</th>
      </tr>
    </thead>
    <tbody  class="table-border-bottom-0" id="topSanPhamBanChay">
    @php
        $tongSoLuongSanPham = 0;
        $tongThanhTien = 0;
        $tongDonHang = 0;
       
    @endphp
    @foreach($lstSanPham as $item)
        @php
            $thanhTien = 0;
            $soLuong = ($item->chitiethoadons_sum_so_luong) ? $item->chitiethoadons_sum_so_luong : 0;
            $donHang = ($item->chitiethoadons_count) ? $item->chitiethoadons_count : 0;
            $thanhTien = $soLuong * $item->gia;
            $tongSoLuongSanPham += $soLuong;
            $tongThanhTien += $thanhTien;
            $tongDonHang += $donHang;
        @endphp
      <tr>
        <tr>
          <td class="text-left">
          </td class="text-left">
          <td>
             
          </td>
          <td class="text-right">
              
          </td>
          <td class="text-right">
             
          </td>
          <td class="text-right">
              
          </td>
        </tr>
      </tr>
    @endforeach
    <tr>
        <td><strong>Tổng:</strong></td>
        <td></td>
        <td class="text-right"><strong>{{ $tongSoLuongSanPham }}</strong></td>
        <td class="text-right"><strong>{{ number_format($tongThanhTien, 0, '', '.')  }} ₫</strong></td>
        <td class="text-right"><strong>{{ $tongDonHang }}</strong></td>
    </tr>
    </tbody>
  </table>