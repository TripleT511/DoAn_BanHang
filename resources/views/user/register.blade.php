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
					<li><a href="#">Category</a></li>
					<li>Page active</li>
				</ul>
		</div>
		<h1>Đăng ký tài Khoản mới</h1>
	</div>
	<!-- /page_header -->
			<div class="row justify-content-center">
			
			<div class="col-xl-6 col-lg-6 col-md-8">
				<div class="box_account">
					<h3 class="new_client">Tài khoản mới</h3> <small class="float-right pt-2">* bắt buộc phải nhập</small>
					<div class="form_container">
						@if($errors->any()) 
                   		 @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                   		 @endforeach
						@endif
						<form method="post" action="{{ route('dangky') }}" >
						@csrf
						<div class="list-preview-image">
							<div class="preview-image-item">
							  <img src="{{ asset('storage/images/user-default.jpg') }}" alt="imgPreview" id="imgPreview">		
							</div>
						</div>
						<div class="form-group">							
							  <div class="button-wrapper form-group">
								<label for="anhDaiDien" class="btn btn_1 me-2 mb-4" >
								  <span class="d-none d-sm-block">Đăng ảnh đại diện</span>
								  <input type="file" name="anhDaiDien" id="anhDaiDien" hidden="" >
								</label>
								<p class="text-muted mb-0">Chấp nhận ảnh JPG, GIF or PNG.</p>
							  </div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="hoTen" id="" placeholder="Họ và tên*....">
						</div>
						<div class="form-group">
							<input type="email" class="form-control" name="email" id="" placeholder="Email*....">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" id=""  placeholder="Password*...">
						</div>
						<div class="form-group">
							<input type="text"  class="form-control phone-mask " name="soDienThoai" id="" placeholder="Số Điện thoại*....">
						</div>
						<div class="form-group">
							<input type="text"  class="form-control " name="" id="" placeholder="Địa chỉ*....">
						</div>
						
						<div class="form-group">
							<div class="row no-gutters">
								<div class="col-6 pr-1">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Thành Phố....">
									</div>
								</div>
								<div class="col-6 pl-1">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="Mã bưu điện....*">
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="container_check">Đồng ý <a href="#0">các điều khoản</a>
								<input type="checkbox">
								<span class="checkmark"></span>
							</label>
						</div>
						<div class="text-center"><input type="submit" value="Register" class="btn_1 full-width"></div>
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