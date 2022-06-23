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
				<form action="{{ route('checkout') }}" method="POST">
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
								<input type="text" class="form-control" name="diaChi_billing" placeholder="Địa chỉ">
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
							<h3>2. Phương thức thanh toán, vận chuyển</h3>
								<ul>
									<li>
										<label class="container_radio">Credit Card<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
											<input type="radio" name="payment" checked>
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_radio">Paypal<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
											<input type="radio" name="payment">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_radio">Cash on delivery<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
											<input type="radio" name="payment">
											<span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_radio">Bank Transfer<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
											<input type="radio" name="payment">
											<span class="checkmark"></span>
										</label>
									</li>
								</ul>
								<div class="payment_info d-none d-sm-block"><figure><img src="img/cards_all.svg" alt=""></figure>	<p>Sensibus reformidans interpretaris sit ne, nec errem nostrum et, te nec meliore philosophia. At vix quidam periculis. Solet tritani ad pri, no iisque definitiones sea.</p></div>
								
								<h6 class="pb-2">Shipping Method</h6>
								
							
							<ul>
								<li>
									<label class="container_radio">Standard shipping<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
										<input type="radio" name="shipping" checked>
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label class="container_radio">Express shipping<a href="#0" class="info" data-toggle="modal" data-target="#payments_method"></a>
										<input type="radio" name="shipping">
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
								<li class="clearfix"><em><strong>Giảm giá </strong></em> <span>{{ number_format(0, 0, '', ',') }} ₫</span></li>
								<li class="clearfix"><em><strong>Phí vận chuyển </strong></em> <span>{{ number_format(0, 0, '', ',') }} ₫</span></li>
								
							</ul>
							<div class="total clearfix">Tổng tiền <span>{{ number_format($total, 0, '', ',') }} ₫</span></div>
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

		})

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

	// 	let btnPayMent = document.querySelector('#payment');
	// 	btnPayMent.addEventListener('click', function() {
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "/thanh-toan",
	// 			dataType: "json",
	// 			data: {
	// 				_token: "{{ csrf_token() }}",
	// 			},
	// 			success: function (response) {
	// 				window.location.href = "{{ route('confirm-checkout')}}";
	// 			}
	// 		});
	// });
</script>
@endsection