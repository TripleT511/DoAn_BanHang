@extends('layouts.user')

@section('title','Tài khoản')

@section('css')

<link href="{{ asset('css/account.css') }}" rel="stylesheet">

@endsection
@section('content')
<main class="bg_gray">
		
	<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Trang chủ</a></li>
					<li>Đăng nhập</li>
				</ul>
		    </div>
        </div>
	</div>
	<!-- /page_header -->
			<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-6 col-md-8">
				<div class="box_account">
					<h3 class="client">Đăng nhập</h3>
                    <form action="{{ route('login') }}" method="POST">
                        {{ @csrf_field() }}
                        <div class="form_container">
                            @if($errors->any()) 
                            @foreach ($errors->all() as $err)
                            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                            @endforeach
                            @endif
                            @if(session('message')) 
                            <label class="text-success mb-2" style="color: #71dd37;">{{ session('message') }}</label>
                            @endif
                            <div class="row no-gutters">
                                <div class="col-lg-6 pr-lg-1">
                                    <a href="#0" class="social_bt facebook">Đăng nhập với Facebook</a>
                                </div>
                                <div class="col-lg-6 pl-lg-1">
                                    <a href="{{route('login_google')}}" class="social_bt google">Đăng nhập với Google</a>
                                </div>
                            </div>
                            <div class="divider"><span>hoặc</span></div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email của bạn..." autofocus>
                            </div>
                            <div class="form-group form-group-password">
                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Nhập mật khẩu của bạn" >
                                <i id="show-password" class="fas fa-eye-slash show-password"></i>
                            </div>
                            <div class="clearfix add_bottom_15">
                                <div class="checkboxes float-left">
                                    <label class="container_check">Nhớ mật khẩu
                                    <input type="checkbox" name="nhomatkhau">
                                    <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="float-right"><a id="forgot" href="javascript:void(0);">Quên mật khẩu?</a></div>
                            </div>
                            <div class="text-center"><input type="submit" value="Đăng nhập" class="btn_1 full-width"></div>
                    </form>
                    <form action="{{ route('Forgot') }}" method="POST">
                        @csrf
                            <div id="forgot_pw">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email_forgot" placeholder="Nhập email tại đây">
                                </div>
                                <div class="text-center"><input type="submit" value="Gửi email xác nhận" class="btn_1"></div>
                            </div>
                             <div style="margin-top: 15px;">
                                Nếu bạn chưa có tài khoản ? <a href="{{ route('user.register') }}">Đăng ký</a>
                            </div>
                            </div>
                            <!-- /form_container -->
                        </div>
                   </form>
				<!-- /box_account -->
				<!-- /row -->
			</div>
			
		</div>
		<!-- /row -->
		</div>
		<!-- /container -->
	</main>
@endsection

@section('js')
<script>
    	// Client type Panel
		$('input[name="client_type"]').on("click", function() {
		    var inputValue = $(this).attr("value");
		    var targetBox = $("." + inputValue);
		    $(".box").not(targetBox).hide();
		    $(targetBox).show();
		});

        let txtPassword = document.querySelector("#password");
        let showPassword = document.querySelector("#show-password");
        showPassword.addEventListener("click", function() { 
            if(showPassword.classList.contains("fa-eye-slash")) {
                txtPassword.type = "text";
                showPassword.classList.remove("fa-eye-slash");
                showPassword.classList.add("fa-eye");
            } else {
                txtPassword.type = "password";
                showPassword.classList.remove("fa-eye");
                showPassword.classList.add("fa-eye-slash");
            }
            
        });

            
	</script>
@endsection