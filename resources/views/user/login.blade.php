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
					<li><a href="#">Home</a></li>
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
		</div>
		<h1>Đăng nhập</h1>
	</div>
	<!-- /page_header -->
			<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-6 col-md-8">
				<div class="box_account">
					<h3 class="client">Already Client</h3>
                    <form action="{{ route('login') }}" method="POST">
                        {{ @csrf_field() }}
                        <div class="form_container">
                            @if($errors->any()) 
                            @foreach ($errors->all() as $err)
                            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                            @endforeach
                            @endif
                            @if(session('message')) 
                            <label class="text-success" >{{ session('message') }}</label>
                            @endif
                            <div class="row no-gutters">
                                <div class="col-lg-6 pr-lg-1">
                                    <a href="#0" class="social_bt facebook">Login with Facebook</a>
                                </div>
                                <div class="col-lg-6 pl-lg-1">
                                    <a href="#0" class="social_bt google">Login with Google</a>
                                </div>
                            </div>
                            <div class="divider"><span>Or</span></div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email của bạn..." autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Nhập mật khẩu của bạn" >
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
                            <div id="forgot_pw">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email_forgot" id="email_forgot" placeholder="Type your email">
                                </div>
                                <p>A new password will be sent shortly.</p>
                                <div class="text-center"><input type="submit" value="Reset Password" class="btn_1"></div>
                            </div>
                            </div>
                            <!-- /form_container -->
                        </div>
                    </form>
				<!-- /box_account -->
				<div class="row">
					<div class="col-md-6 d-none d-lg-block">
						<ul class="list_ok">
							<li>Find Locations</li>
							<li>Quality Location check</li>
							<li>Data Protection</li>
						</ul>
					</div>
					<div class="col-md-6 d-none d-lg-block">
						<ul class="list_ok">
							<li>Secure Payments</li>
							<li>H24 Support</li>
						</ul>
					</div>
				</div>
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
	</script>
@endsection