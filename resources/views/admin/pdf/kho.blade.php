<!DOCTYPE html>
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
        <span>Năm {{  $phieukho->created_at->format('Y') }}</span>
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
</html>

