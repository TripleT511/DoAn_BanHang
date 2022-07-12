{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" >
  
    <title>Phiếu Nhập</title>   
</head>
<body>
  <div class="container">
    <h5>TRIPLE T SHOP</h5>
    <div class="p-3">
      <div>
        <p class="text-center h3">Chi Tiết Phiếu Kho</p>
      </div>
      <div class="text-center">
        <span>Ngày {{  $phieukho->created_at->format('d') }}</span>
        <span>Tháng {{  $phieukho->created_at->format('m') }}</span>
        <span>Năm 20{{  $phieukho->created_at->format('y') }}</span>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Mã hàng</th>
          <th scope="col">Tên sản phẩm</th>
          <th scope="col">Số lượng</th>
          <th scope="col">Đơn giá</th>
          <th scope="col">Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        @foreach($chitietphieukho as $key=>$item)
       
        <tr>
          <th scope="row">{{ $key++ }}</th>
          <td>{{ $item->sku }}</td>
          <td>{{ $item->sanpham->tenSanPham }}</td>
          <td>{{ $item->soLuong }}</td>
          <td>{{number_format($item->gia, 0, ',', ',') }} đ</td>
          <td>{{number_format((float)$item->gia * (int)$item->soLuong, 0, ',', ',') }} đ</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    
  </div>
    
    

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js" ></script>
 
</body>
</html> --}}

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
    <h1 class="text-center m-0 p-0">Chi Tiết Phiếu Kho</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Mã đơn hàng: <span class="gray-color"></span></p>
        <p class="m-0 pt-5 text-bold w-100">Trạng thái đơn hàng: <span class="gray-color"></span></p>
        <p class="m-0 pt-5 text-bold w-100">Ngày tạo: <span class="gray-color"> {{  $phieukho->created_at->format('d') }}-{{  $phieukho->created_at->format('m') }}-20{{  $phieukho->created_at->format('y') }}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
        {{-- <img src="https://www.nicesnippets.com/image/imgpsh_fullsize.png"> <span>Nicesnippets.com</span>      --}}
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
       
        <tr>
            <td>
                <div class="box-text">
                    <p>Mã đơn hàng: </p>
                    <p>Thời gian: </p>
                    <p>Trạng thái: </p>
                    
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>Nhà cung cấp: </p>
                    <p>Người tạo:</p>
                    <p>Ghi chú</p>
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
        @foreach($chitietphieukho as $key=>$item)
        <tr align="center">
          <td>{{ $key++ }}</td>
          <td>{{ $item->sku }}</td>
          <td>{{ $item->sanpham->tenSanPham }}</td>
          <td>{{ $item->soLuong }}</td>
          <td>{{number_format($item->gia, 0, ',', ',') }} đ</td>
          <td>{{number_format((float)$item->gia * (int)$item->soLuong, 0, ',', ',') }} đ</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Thành tiền:</p>
                        <p>Giảm giá:</p>
                        <p>Tổng cộng:</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>10000</p>
                        <p></p>
                        <p></p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>