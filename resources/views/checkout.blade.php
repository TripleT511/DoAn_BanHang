@extends('layouts.user')

@section('title','Thanh toán')

@section('css')

<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
<style>
	.tab-content.checkout {
		padding: 0;
	}
	.text-validate {
		color: red;
	}

	input:invalid {
		border-color: #c00000;
	}

	.container_radio .img {
		width: 50px;
	}

	.container_radio .img img {
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
					<li><a href="#">Giỏ hàng</a></li>
					<li>Thanh toán</li>
				</ul>
		</div>
		<h1>Thanh toán</h1>
			
	</div>
	<!-- /page_header -->
			<div class="row">
				<div class="col-lg-4 col-md-6">
				<form action="{{ route('thanhtoanDefault') }}" id="form-checkout" method="POST">
					@csrf
					<div class="step first">
						<h3>1. Thông tin thanh toán</h3>
					
					<div class="tab-content checkout">
						<div class="tab-pane fade show active"  >
							<div class="row no-gutters">
								<div class="col-6 form-group pr-1">
									<input type="text" class="form-control" name="hoTen_billing" placeholder="Họ và tên" value="{{ $user->hoTen }}">
									<span class="text-validate" id="validate-sdt">
										@if($errors->has('hoTen_billing')) 
											{{ $errors->first('hoTen_billing') }}
										@endif
									</span>
								</div>
								<div class="col-6 form-group pl-1">
									<input type="text" class="form-control" id="soDienThoai" pattern="(09|03|07|08|05)+([0-9]{8,9})\b" name="soDienThoai_billing" placeholder="Số điện thoại" value="{{ $user->soDienThoai }}">
									<span class="text-validate" id="validate-sdt">
										@if($errors->has('soDienThoai_billing')) 
											{{ $errors->first('soDienThoai_billing') }}
										@endif
									</span>
								</div>
							</div>
							<!-- /row -->
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email_billing" pattern="^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$" placeholder="Email" value="{{ $user->email }}">
								<span class="text-validate" id="validate-email">
									@if($errors->has('email_billing')) 
										{{ $errors->first('email_billing') }}
									@endif
								</span>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="diaChi_billing" placeholder="Địa chỉ" value="{{ $user->diaChi }}">
								<span class="text-validate" id="validate-sdt">
									@if($errors->has('diaChi_billing')) 
										{{ $errors->first('diaChi_billing') }}
									@endif
								</span>
							</div>
							<hr>
						</div>
						<div class="form-group">
							<textarea name="ghiChu_billing" class="form-control" cols="30" rows="7"></textarea>
						</div>
						<!-- /tab_1 -->
					</div>
					</div>
					<!-- /step -->
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="step middle payments">
							<h3>2. Phương thức thanh toán</h3>
							<ul style="margin-bottom:
							10px;">
								<li>
									<label class="container_radio">
										Thanh toán khi nhận hàng (COD)<a href="#0" class="info" ></a>
										<input type="radio" name="redirect" value="{{ route('thanhtoanDefault') }}" checked>
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label class="container_radio">
										<div class="img">
											<img src="{{ asset('img/thanh-toan/logo-vnpay.png') }}" alt="VNPAY QR">
										</div>
										Thanh toán qua VNPAY<a href="#0" class="info" ></a>
										<input type="radio" name="redirect" value="{{ route('paymentVNPay') }}">
										<span class="checkmark"></span>
									</label>
								</li>
							</ul>
						</div>
						<!-- /step -->
						
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="step last">
							<h3>3. Tóm tắt đơn hàng</h3>
						<div class="box_general summary">
							<ul>
								@foreach($Cart as $item) 
									<li class="clearfix"><em>{{ $item['soluong'] }}x {{ $item['tenSanPham'] }}</em>  
										<span>{{ number_format($item['tongTien'], 0, '', ',') }} ₫</span>
									</li>
								@endforeach
							</ul>
							<ul>
								<li class="clearfix"><em><strong>Tạm tính</strong></em>  <span>{{ number_format($total, 0, '', ',') }} ₫</span></li>
								<li class="clearfix"><em><strong>Giảm giá </strong></em> <span>{{ $discount }} ₫</span></li>
								<li class="clearfix"><em><strong>Phí vận chuyển </strong></em> <span>{{ number_format(0, 0, '', ',') }} ₫</span></li>
								
							</ul>
							<div class="total clearfix">Tổng tiền <span>{{ number_format($newTotal, 0, '', ',') }} ₫</span></div>
							<input type="hidden" name="tongTien" value="{{ $total }}">
							<button type="submit" id="payment" class="btn_1 full-width">Thanh toán</button>
						</div>
						<!-- /box_general -->
						</div>
						<!-- /step -->
					</div>
				</form>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
@endsection

@section('js')
<script>

	$(document).ready(function(){
		$.ajax({
			type: "GET",
			url: "/render-cart",
			dataType: "json",
			success: function (response) {
				$("#lstItemCart").html(response.newCart);
				document.querySelector(".total_drop div span").innerHTML = `${response.total} ₫`;
				document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
			}
		});
	})
		let txtSoDienThoai = document.querySelector("#soDienThoai");
		let txtEmail = document.querySelector("#email");

		txtSoDienThoai.addEventListener("blur", function(event) {
			if(!txtSoDienThoai.checkValidity()) {
			document.querySelector("#validate-sdt").innerHTML = "Số điện thoại không hợp lệ";
			} else {
				document.querySelector("#validate-sdt").innerHTML = "";
			}

		});

		let radCheckout = document.querySelectorAll('input[name="redirect"]');
		radCheckout.forEach(item => item.addEventListener('change', function(e) {
				document.getElementById("form-checkout").action = e.target.value;
			})
		);

		txtEmail.addEventListener("blur", function(event) {
			if(!txtEmail.checkValidity()) {
			document.querySelector("#validate-email").innerHTML = "Địa chỉ email không hợp lệ";
			} else {
				document.querySelector("#validate-email").innerHTML = "";
			}

		})
		
    	// Other address Panel
		$('#other_addr input').on("change", function (){
	        if(this.checked)
	            $('#other_addr_c').fadeIn('fast');
	        else
	            $('#other_addr_c').fadeOut('fast');
	    });

</script>
@endsection