<!DOCTYPE html>
<html lang="en">
<head>
    < <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Phiếu Nhập</title>   
    <style>
        .text-center {
    text-align: center !important;
        }
    </style>
</head>
<body>
    <h5>TRIPLET SHOP</h5>
    <h3 class="text-center">Chi Tiết Phiếu Kho</h3>
    <dl class="row mt-2">
        <dt class="col-sm-3">Mã đơn hàng:</dt>
        <dd class="col-sm-3" id="maDonHang"> {{$madonhang}}  </dd>
        <dt class="col-sm-3">Nhà cung cấp:</dt>
        <dd class="col-sm-3" id="nhaCungCap">
        
       </dd>
        <dt class="col-sm-3 text-truncate">Thời gian</dt>
       <dd class="col-sm-3" id="ngayTao">
     
        </dd>
        <dt class="col-sm-3">Người tạo:</dt>
        <dd class="col-sm-3" id="nguoiNhap">
        
        </dd>
        <dt class="col-sm-3">Trạng thái:</dt>
        <dd class="col-sm-3" id="trangThai">
          
        </dd>
        <dt class="col-sm-3">Ghi chú</dt>
        <dd class="col-sm-3">     </dd>
        
      </dl>
    <table class="table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Mã hàng</th>
          <th>Tên sản phẩm</th>
          <th>Số Lượng</th>
          <th>Đơn giá</th>
          <th>Thành tiền</th>
        </tr>
      </thead>
    <tbody class="table-border-bottom-0">
      <tr>
        <td>
           
        </td>
        <td>
            
        </td>
        <td>
            
        </td>
        
        <td>
            
        </td>
        <td>         
             đ
        </td>
        <td>
             đ
        </td>
    </tr>
  </tbody>
</table>
<div class="row">
    <div class="col-md-8">
        
    </div>
    <div class="col-md-4">
        <div class="row">
            <dt class="col-sm-5 text-right">Tổng số lượng: </dt>
            <dd class="col-sm-7 text-right">  </dd>
            <dt class="col-sm-5 text-right">Tổng số mặt hàng: </dt>
            <dd class="col-sm-7 text-right">  </dd>
            <dt class="col-sm-5 text-right">Tổng tiền hàng: </dt>
            <dd class="col-sm-7 text-right"> đ</dd>
            <dt class="col-sm-5 text-right">Tổng cộng: </dt>
            <dd class="col-sm-7 text-right"> đ</dd>
        </div>
    </div>
</div>
</body>
</html>
