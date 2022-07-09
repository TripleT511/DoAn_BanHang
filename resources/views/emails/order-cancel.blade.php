@component('mail::message')
<h4 style="color: #0f146d; text-align: center; font-size:23px;">Đơn hàng của bạn đã được hủy</h4>
<p style="color: #202020;">{{ $hoadon->hoTen }} ơi,</p>
<p style="color: #202020;">Đơn hàng #{{ $hoadon->id }} đã được hủy theo yêu cầu của bạn.</p>
@endcomponent