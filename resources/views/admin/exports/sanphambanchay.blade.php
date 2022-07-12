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
    <tbody class="table-border-bottom-0" id="topSanPhamBanChay">
    @php
        $tongSoLuongSanPham = 0;
        $tongThanhTien = 0;
        $tongDonHang = 0;
    @endphp
    @foreach($top5SanPhamBanChay as $key => $item)
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
        <td class="text-left">
            {{ ++$key }}
        </td class="text-left">
        <td>
            <a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}" class="text-primary" target="_blank" title="{{ $item->tenSanPham }}">
                {{ $item->tenSanPham }}
            </a>
        </td>
        <td class="text-right">
            {{ $soLuong }}
        </td>
        <td class="text-right">
           {{ number_format($thanhTien, 0, '', ',') }} ₫
        </td>
        <td class="text-right">
            {{ $donHang }}
        </td>
      </tr>
    @endforeach
    <tr>
        <td><strong>Tổng:</strong></td>
        <td></td>
        <td class="text-right"><strong>{{ $tongSoLuongSanPham }}</strong></td>
        <td class="text-right"><strong>{{ number_format($tongThanhTien, 0, '', ',') }} ₫</strong></td>
        <td class="text-right"><strong>{{ $tongDonHang }}</strong></td>
    </tr>
    </tbody>
  </table>