<!DOCTYPE html>
<html>
<head>
    <title>Hoá Đơn</title>
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
    <h1 class="text-center m-0 p-0">Chi Tiết Hoá Đơn</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Mã đơn hàng: <span class="gray-color"></span></p>
        <p class="m-0 pt-5 text-bold w-100">Trạng thái đơn hàng: <span class="gray-color"></span></p>
        <p class="m-0 pt-5 text-bold w-100">Ngày tạo: <span class="gray-color">03-06-2022</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
        {{-- <img src="https://www.nicesnippets.com/image/imgpsh_fullsize.png"> <span>Nicesnippets.com</span>      --}}
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Thông tin thanh toán</th>
            <th class="w-50">Thông tin khách hàng</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>Họ tên:: </p>
                    <p>Email:</p>
                    <p>Số điện thoại:</p>
                    
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>Họ tên:: </p>
                    <p>Email:</p>
                    <p>Số điện thoại:</p>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">STT</th>
            <th class="w-50">TÊN SẢN PHẨM</th>
            <th class="w-50">SỐ LƯỢNG</th>
            <th class="w-50">ĐƠN GIÁ</th>
            <th class="w-50">THÀNH TIỀN</th>
        </tr>
        
        <tr align="center">
            <td>A</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
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