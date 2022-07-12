@component('mail::message')
<h4 style="color: #0f146d; text-align: center; font-size:23px;">Xác nhận đặt lại mật khẩu</h4>

<p style="color: #202020; text-align: center;">Xin chào {{ $user->hoTen }},
Có vẻ bạn đã yêu cầu đặt lại mật khẩu cho tài khoản của mình. Nếu bạn đã làm điều đó vui lòng nhấp vào liên kết dưới đây và làm theo hướng dẫn để đặt lại mật khẩu của bạn.
</p>
<div style="text-align: center;">
    <a href="{{ route('user.showFormReset', ['token' => $token]) }}" style="display: inline-block; padding: 10px 15px; background-color: #004dda; color: #fff; border-radius: 7px; text-decoration: none;">Đặt lại mật khẩu</a>
</div>
<p style="color: #202020;"><strong>*Lưu ý: </strong>Link này chỉ có hiệu lực trong <span style="color: #0f146d;">5</span>  phút.</p>
<p  style="color: #202020; text-align: center; margin-top:15px">Nếu bạn không làm điều đó, vui lòng <a href="#" style="color:#0f146d; text-decoration:none;">Liên hệ với bộ phận hỗ trợ</a> ngay lập tức.</p>

@endcomponent