@component('mail::message')
<h4 style="color: #0f146d; text-align: center; font-size:23px;">Cảm ơn <strong> {{ $user->hoTen }}</strong> đã đặt hàng tại TripleT Shop!</h4>
<p style="color: #202020;">Xin chào {{ $user->hoTen }},</p>
<p style="color: #202020;">Shop đã nhận được yêu cầu đặt hàng của bạn và đang xử lý nhé.</p>

<p style="color: #202020;"><strong>*Lưu ý nhỏ cho bạn: </strong>Bạn chỉ nên nhận hàng khi trạng thái đơn hàng là “Đang giao hàng” và nhớ kiểm tra Mã đơn hàng, Thông tin người gửi để nhận đúng kiện hàng nhé.</p>

@component('mail::table')
| <p style="color: #202020; font-size: 18px; text-align: left; margin: 0;">Thông tin thanh toán </p>|            |
| -------------------------- |:---------------------------:|
| <strong  style="color: #004dda; font-size: 14px;">Họ tên:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $user->hoTen }}</p>|
| <strong  style="color: #004dda; font-size: 14px;">Email:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $user->email }}</p>|
| <strong  style="color: #004dda; font-size: 14px;">Số điện thoại:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $user->soDienThoai }}</p>|
@endcomponent
@component('mail::table')
| <p style="color: #202020; font-size: 18px;text-align: left; margin: 0;">Địa chỉ giao hàng </p>|            |
| -------------------------- |:---------------------------:|
| <strong  style="color: #004dda; font-size: 14px;">Họ tên:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $hoadon->hoTen }}</p>|
| <strong  style="color: #004dda; font-size: 14px;">Địa chỉ:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $hoadon->diaChi }}</p>|
| <strong  style="color: #004dda; font-size: 14px;">Số điện thoại:</strong>|<p style="color: #202020; text-align: left; font-weight: normal; margin: 0;">{{ $hoadon->soDienThoai }}</p>|
@endcomponent
<h4 style="color: #202020; font-size: 18px; font-weight: bold;">Chi tiết đơn hàng</h4>
@component('mail::table')
|<span style="color: #202020;">STT</span>|<span style="color: #202020;">SẢN PHẨM</span>|<span style="color: #202020;">GIÁ</span>|<span style="color: #202020;">SỐ LƯỢNG</span>|<span style="color: #202020;">THÀNH TIỀN</span>|
|:-----:|:--------:|:----:|:--------:|:----------:|
@foreach($data as $key=>$dt)
|<span style="color: #202020; font-size:14px; font-weight:normal;">{{ ++$key}}</span>|<span style="color: #202020; font-size:14px; font-weight:normal;">{{ $data[--$key]['tenSanPham'] }}</span>|<span style="color: #202020; font-size:14px; font-weight:normal;">{{number_format( $dt['donGia'], 0, '', '.')  }} ₫</span>|<span style="color: #202020; font-size:14px; font-weight:normal;"> {{$dt['soLuong']}}</span>|<span style="color: #202020; font-size:14px; font-weight:normal;">{{number_format( $dt['tongTien'], 0, '', '.')  }} ₫</span>|
@endforeach
@endcomponent
@component('mail::table')
|       |          |
|:-----:|:--------:|
|<p style="color: #202020; font-size:14px; font-weight:normal; text-align:left; margin: 0;">Thành tiền:</p>|<p style="color: #202020; font-size:14px; font-weight:normal; margin: 0;text-align: right;">{{ $infoPayMent["thanhTien"] }}</p>|
|<p style="color: #202020; font-size:14px; font-weight:normal; text-align:left; margin: 0;">Phí vận chuyển:</p>|<p style="color: #202020; font-size:14px; font-weight:normal; margin: 0;text-align: right;">{{ $infoPayMent["vanChuyen"] }}</p>|
|<p style="color: #202020; font-size:14px; font-weight:normal; text-align:left; margin: 0;">Giảm giá:</p>|<p style="color: #202020; font-size:14px; font-weight:normal; margin: 0;text-align: right;">-{{$infoPayMent["giamGia"] }}</p>|
|<p style="color: #202020; font-size:14px; font-weight:normal; text-align:left; margin: 0;">Tổng cộng:</p>|<p style="color: #202020; font-size:14px; font-weight:normal; margin: 0;text-align: right;">{{ $infoPayMent["tongCong"] }}</p>|
|<p style="color: #202020; font-size:14px; font-weight:normal; text-align:left; margin: 0;">Hình thức thanh toán:</p>|<p style="color: #202020; font-size:14px; font-weight:normal; margin: 0;text-align: right;">{{ $infoPayMent["hinhThuc"] }}</p>|
@endcomponent
<p style="color: #202020;"><strong>Ghi chú: </strong>{{ $hoadon->ghiChu }}</p>
@endcomponent
