
<!DOCTYPE html>
<html>
<head>
    <title>Phiếu Kho</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto';
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h2 class="text-center m-0 p-0">PHIẾU NHẬP KHO</h2>
</div>
@php
$trangThai = $phieukho->trangThai == 0 ? "Đang chờ duyệt" : "Đã thanh toán";
$nhacungcap = ($phieukho->nha_cung_cap_id ? $phieukho->nhacungcap->tenNhaCungCap : '');
$nguoiTao = ($phieukho->user ? $phieukho->user->hoTen : '');
@endphp
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
       
        <tr>
            <td>
                <div class="box-text">
                    <p>Mã đơn hàng: {{ $phieukho->maDonHang }}</p>
                    <p>Thời gian: {{  $phieukho->created_at->format('d') }}-{{  $phieukho->created_at->format('m') }}-{{  $phieukho->created_at->format('Y') }}</p>
                    <p>Trạng thái: {{ $trangThai }}</p>
                    
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>Nhà cung cấp: {{ $nhacungcap }}</p>
                    <p>Người tạo: {{ $nguoiTao }}</p>
                    <p>Ghi chú: {{ $phieukho->ghiChu }}</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">STT</th>
            <th class="w-50">MÃ HÀNG</th>
            <th class="w-50">TÊN SẢN PHẨM</th>
            <th class="w-50">SỐ LƯỢNG</th>
            <th class="w-50">ĐƠN GIÁ</th>
            <th class="w-50">THÀNH TIỀN</th>
        </tr>
        @php
            $tongSL = 0;
            $tongSP = 0;
            $tongTien = 0;
        @endphp
        @foreach($chitietphieukho as $key=>$item)
        @php
            $tongSL += $item->soLuong;
            $tongSP += 1;
            $tongTien += (int)$item->soLuong * (float)$item->gia;
        @endphp
        <tr align="center">
          <td>{{ ++$key }}</td>
          <td>{{ $item->sku }}</td>
          <td>{{ $item->sanpham->tenSanPham }} - {{ $item->tieuDeColor }} {{ ($item->tieuDeSize != '') ? ' - ' . $item->tieuDeSize : '' }}</td>
          <td>{{ $item->soLuong }}</td>
          <td>{{number_format($item->gia, 0, ',', ',') }} ₫</td>
          <td>{{number_format((float)$item->gia * (int)$item->soLuong, 0, ',', ',') }} ₫</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Tổng số lượng:</p>
                        <p>Tổng số mặt hàng:</p>
                        <p>Tổng tiền hàng:</p>
                        <p>Tổng cộng:</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>{{ $tongSL }}</p>
                        <p>{{ $tongSP }}</p>
                        <p>{{ number_format($tongTien, 0, ',', ',') }} ₫</p>
                        <p>{{ number_format($tongTien, 0, ',', ',') }} ₫</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>