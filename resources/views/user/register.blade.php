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
					<li>Đăng ký</li>
				</ul>
		</div>
		<h1>Đăng ký</h1>
	</div>
	<!-- /page_header -->
			<div class="row justify-content-center">
			
			<div class="col-xl-6 col-lg-6 col-md-8">
				<div class="box_account">
					<h3 class="new_client">Tạo tài khoản</h3>
					<div class="form_container">
						@if($errors->any()) 
                   		 @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                   		 @endforeach
						@endif
						<form method="post" action="{{ route('dangky') }}" >
						@csrf
						
						<div class="form-group">
							<input type="text" class="form-control" name="hoTen" id="" placeholder="Nhập họ và tên">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" id="" placeholder="Nhập email">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" id=""  placeholder="Nhập mật khẩu">
						</div>
						<div class="form-group">
							<input type="text"  class="form-control phone-mask " name="soDienThoai" id="" placeholder="Nhập số điện thoại">
						</div>
						<div>
							{!! NoCaptcha::renderJs() !!}
							{!! NoCaptcha::display() !!}
						</div>
						<div class="text-center " style="margin-top:10px;"><input type="submit" value="Đăng ký" class="btn_1 full-width"></div>
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
    	// Client type Panel
		$('input[name="client_type"]').on("click", function() {
		    var inputValue = $(this).attr("value");
		    var targetBox = $("." + inputValue);
		    $(".box").not(targetBox).hide();
		    $(targetBox).show();
		});
		$("#anhDaiDien").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".list-preview-image").css('display', 'flex');
                
                $("#imgPreview").show().attr("src", filePath);
               
            });
	</script>
@endsection