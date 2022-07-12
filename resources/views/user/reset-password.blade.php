@extends('layouts.user')

@section('title','Tài khoản')

@section('css')

<link href="{{ asset('css/account.css') }}" rel="stylesheet">
<style>

	.preview-image-item {
		width: 100px;
		height: 100px;
		position: relative;
		overflow: hidden;
		border-radius: 0.375rem ;
	}

	.preview-image-item img {
		display: flex;
		margin: auto;
		width: 100%;
		height: 100%;
		object-fit: contain;
	}
</style>
@endsection
@section('content')
<main class="bg_gray">
		
	<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Trang chủ</a></li>
				</ul>
		</div>
	</div>
	<!-- /page_header -->
			<div class="row justify-content-center">
			
			<div class="col-xl-6 col-lg-6 col-md-8">
				<div class="box_account">
					<h3 class="new_client">Cập nhật mật khẩu</h3>
					<div class="form_container">
						@if($errors->any()) 
                   		 @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                   		 @endforeach
						@endif
                        @if(session('error')) 
                            <label class="text-danger" style="color: #fc424a;" >{{ session('error') }}</label>
                        @endif
						<form method="post" action="{{ route('user.resetPassword', ['token' => $token]) }}" >
						@csrf
						@method("POST")
						<div class="form-group form-group-password">
							<input type="password" class="form-control" name="password" id="password"  placeholder="Nhập mật khẩu">
							<i id="show-password" class="fas fa-eye-slash show-password"></i>
						</div>
                        <div class="form-group form-group-password">
							<input type="password" class="form-control" name="confirm-password" id="confirm-password"  placeholder="Nhập mật khẩu">
							<i id="show-password2" class="fas fa-eye-slash show-password"></i>
						</div>
						<div class="text-center " style="margin-top:10px;"><input type="submit" value="Gửi" class="btn_1 full-width"></div>
					</form>
					</div>
					<!-- /form_container -->
				</div>
				<!-- /box_account -->
			</div>
		</div>
		<!-- /row -->
		</div>
		<!-- /container -->
	</main>
@endsection

@section('js')
<script>
    

        let txtPassword = document.querySelector("#password");
        let txtConfirmPassword = document.querySelector("#confirm-password");
        let showPassword = document.querySelector("#show-password");
        let showPassword2 = document.querySelector("#show-password2");
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

        showPassword2.addEventListener("click", function() { 
            if(showPassword2.classList.contains("fa-eye-slash")) {
                txtConfirmPassword.type = "text";
                showPassword2.classList.remove("fa-eye-slash");
                showPassword2.classList.add("fa-eye");
            } else {
                txtConfirmPassword.type = "password";
                showPassword2.classList.remove("fa-eye");
                showPassword2.classList.add("fa-eye-slash");
            }
            
        });

            
	</script>
@endsection