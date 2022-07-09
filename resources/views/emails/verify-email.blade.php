@component('mail::message')
<h4 style="color: #0f146d; text-align: center; font-size:23px;">Xác nhận địa chỉ email</h4>

<p style="color: #202020; text-align: center;">Cảm ơn bạn đã đăng ký tài khoản tại Triple T Shop
</p>

<p style="color: #202020; text-alignL: center;">Vui lòng nhấp vào liên kết dưới đây để xác nhận địa chỉ email của bạn
</p>

<div style="text-align: center;">
    <a href="{{ route('verification.verify', ['id' => $user["id"] , 'hash' => $hash]) }}" style="display: inline-block; padding: 10px 15px; background-color: #004dda; color: #fff; border-radius: 7px; text-decoration: none;">Xác nhận tài khoản</a>
</div>

@endcomponent