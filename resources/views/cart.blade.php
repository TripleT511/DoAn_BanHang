@extends('layouts.user')

@section('title','Giỏ hàng')

@section('css')

<link href="{{ asset('css/cart.css') }}" rel="stylesheet">
<style>
	.table.cart-list th:nth-child(1) {
		width: 50%;
	}
	.table.cart-list th:nth-child(3) {
    	width: 15%;
	}
	.table.cart-list th:nth-child(4) {
		width: 15%;
	}

	.cart-empty .img {
		width: 300px;
		height: 300px;
		margin: 0 auto;
	}

	.cart-empty .img img {
		width: 100%;
		height: 100%;
		object-fit: contain;
		display: flex;
		margin: auto;
	}

	.box_cart ul li:last-child {
		text-transform: inherit;
		font-weight: inherit;
		color: inherit;
		font-size: inherit;
	}

	.box_cart ul li:last-child b {
		color: rgb(254, 56, 52);
		font-size: 22px;
		font-weight: 400;
	}
	p.cart-price {
		margin-bottom: 0;
	}
</style>
@endsection
@section('content')
<div class="toast toast-success fade">
	<div class="toast-header">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M439.39 362.29c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71zM67.53 368c21.22-27.97 44.42-74.33 44.53-159.42 0-.2-.06-.38-.06-.58 0-61.86 50.14-112 112-112s112 50.14 112 112c0 .2-.06.38-.06.58.11 85.1 23.31 131.46 44.53 159.42H67.53zM224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64z"/></svg>
		<div class="me-auto fw-semibold">Thông báo</div>
		<small>1 second ago</small>
		<div class="close-toast">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>
		</div>
	</div>
	<div class="toast-body">
		Fruitcake chocolate bar tootsie roll gummies gummies jelly beans cake.
	</div>
</div>
<main class="bg_gray" id="cart-wrapper">
		<!-- /page_header -->
		@if($Cart)
		<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Trang chủ</a></li>
					<li>Giỏ hàng</li>
				</ul>
			</div>
			<h1>Giỏ hàng</h1>
		</div>
		<table class="table table-striped cart-list">
							<thead>
								<tr>
									<th>
										Sản phẩm
									</th>
									<th>
										Đơn giá
									</th>
									<th>
										Số lượng
									</th>
									<th>
										Thành tiền
									</th>
									<th>
										
									</th>
								</tr>
							</thead>
							<tbody id="lstCart">
								@foreach($Cart as $item) 
								<tr>
									<td>
										<div class="thumb_cart">
											<img src="{{ asset('storage/' . $item['hinhAnh']) }}" data-src="{{ asset('storage/' . $item['hinhAnh']) }}" class="lazy" alt="Image">
										</div>
										<span class="item_cart">{{ $item['tenSanPham'] }}</span>
									</td>
									<td>
										<strong>{{ number_format($item['gia'], 0, '', ',') }} ₫</strong>
									</td>
									<td>
										<div class="numbers-row">
											<input type="text" value=" {{ $item['soluong']}} " id="quantity_1" class="qty2" name="quantity_1">
									</div>
									</td>
									<td>
										<strong>{{ number_format($item['tongTien'], 0, '', ',') }}  ₫</strong>
									</td>
									<td class="options">
										<a href="#" class="btn-trash" data-id="{{ $item['id'] }}"><i class="ti-trash"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>

						<div class="row add_top_30 flex-sm-row-reverse cart_actions">
						
						<div class="col-sm-12">
							<div class="apply-coupon">
								<div class="form-group form-inline">
									<input type="text" name="coupon-code" value="" placeholder="Mã giảm giá" class="form-control"><button type="button" class="btn_1 outline">Sử dụng</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /cart_actions -->
	
		</div>
		<!-- /container -->
		
		<div class="box_cart">
			<div class="container">
			<div class="row justify-content-end">
				<div class="col-xl-4 col-lg-4 col-md-6">
			<ul class="info-cart">
				<li>
					<span>Tạm tính:</span> 
					<p class="cart-price">{{ number_format($total, 0, '', ',') }} ₫</p>
				</li>
				<li>
					<span>Giảm giá:</span> 0 ₫
				</li>
				<li>
					<span>Phí vận chuyển:</span> 0 ₫
				</li>
				<li>
					<span>Tổng cộng:</span> 
					<b  class="cart-total">{{ number_format($total, 0, '', ',') }} ₫</b>
				</li>
			</ul>
			<a href="{{ route('checkout') }}" class="btn_1 full-width cart">Đi đến trang thanh toán</a>
					</div>
				</div>
			</div>
		</div>
		<!-- /box_cart -->
		@else
		<div class="container mb-5">
			<div class="row">
				<div class="col-md-12">
						<div class="cart-empty">
							<div class="img">
								<img src="{{ asset('img/cart-empty.png') }}" alt="Giỏ hàng trống">
							</div>
							<h3 class="text-center">
								<strong>Bạn chưa có sản phẩm nào trong giỏ hàng</strong>
							</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@endif
	</main>

@endsection
@section('js')
<script>
	// Render Cart khi vừa vô trang 
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

		let lstBtnDelete = document.querySelectorAll(".btn-trash");
		let lstBtnIncre = document.querySelectorAll(".inc.button_inc");
		let lstBtnDecre = document.querySelectorAll(".dec.button_inc");
		let lstBtnQty = document.querySelectorAll(".qty2");

		// Câp nhật số lượng sản phẩm trong giỏ hàng //
		lstBtnIncre.forEach((item, index) => item.addEventListener('click', function() {
			console.log("a");
			let soLuong = lstBtnQty[index].value;
			if(isNaN(soLuong)) {
				let toast = document.querySelector(".toast");
				toast.querySelector(".toast-body").innerHTML = "Số lượng không hợp lệ";
				toast.classList.remove("toast-success");
					toast.classList.add("toast-danger", "show");
				setTimeout(() => {
					toast.classList.remove("show");
					}, 2000);
				return;
			} 
			$.ajax({
			type: "POST",
			url: "/update-cart",
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				soLuong: soLuong,
				sanphamId: lstBtnDelete[index].getAttribute("data-id")
			},
			success: function (response) {
				refreshEvent(response);	
			}
			});
		}));

		lstBtnDecre.forEach((item, index) => item.addEventListener('click', function() {
			console.log("b");
			let soLuong = lstBtnQty[index].value;
			if(isNaN(soLuong) || soLuong < 0) {
				let toast = document.querySelector(".toast");
				toast.querySelector(".toast-body").innerHTML = "Số lượng không hợp lệ";
				toast.classList.remove("toast-success");
					toast.classList.add("toast-danger", "show");
				setTimeout(() => {
					toast.classList.remove("show");
					}, 2000);
				return;
			}
			$.ajax({
			type: "POST",
			url: "/update-cart",
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				soLuong: soLuong,
				sanphamId: lstBtnDelete[index].getAttribute("data-id")
			},
			success: function (response) {
				refreshEvent(response);	
			}
			});
		}));

		// Câp nhật số lượng sản phẩm trong giỏ hàng //

		// Xoá giỏ hàng //
		lstBtnDelete.forEach(item => item.addEventListener('click', function() {
			$.ajax({
			type: "POST",
			url: "/remove-cart",
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				sanphamId: this.dataset.id
			},
			success: function (response) {
				refreshEvent(response);	
			}
			});
		}));

		// Xoá giỏ hàng //

		function refreshEvent(response) {

				$("#lstItemCart").html(response.newCart);
				document.querySelector(".total_drop div span").innerHTML = `${response.total} ₫`;
				document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
				if(response.numberCart == 0) {
					document.querySelector("#cart-wrapper").innerHTML = response.cartMain;
				} else {
					document.querySelector("#lstCart").innerHTML = response.cartMain;
					document.querySelector(".cart-price").innerHTML = `${response.total} ₫`;
					document.querySelector(".cart-total").innerHTML = `${response.total} ₫`;
				}

				lstBtnDelete = document.querySelectorAll(".btn-trash");
				lstBtnIncre = document.querySelectorAll(".inc.button_inc");
				lstBtnDecre = document.querySelectorAll(".dec.button_inc");
				lstBtnQty = document.querySelectorAll(".qty2");


				lstBtnIncre.forEach((item, index) => item.addEventListener('click', function() {
					//
					var $button = $(this);
					var oldValue = $button.parent().find("input").val();
					if ($button.text() == "+") {
						var newVal = parseFloat(oldValue) + 1;
					} else {
						// Don't allow decrementing below zero
						if (oldValue > 1) {
							var newVal = parseFloat(oldValue) - 1;
						} else {
							newVal = 0;
						}
					}
					$button.parent().find("input").val(newVal);

					//

					let soLuong = lstBtnQty[index].value;
				
					if(isNaN(soLuong)) {
						let toast = document.querySelector(".toast");
						toast.querySelector(".toast-body").innerHTML = "Số lượng không hợp lệ";
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						return;
					} 
					$.ajax({
					type: "POST",
					url: "/update-cart",
					dataType: "json",
					data: {
						_token: "{{ csrf_token() }}",
						soLuong: soLuong,
						sanphamId: lstBtnDelete[index].getAttribute("data-id")
					},
					success: function (response) {
						refreshEvent(response);	
					}
					});
				}));

				lstBtnDecre.forEach((item, index) => item.addEventListener('click', function() {
						//
					var $button = $(this);
					var oldValue = $button.parent().find("input").val();
					if ($button.text() == "+") {
						var newVal = parseFloat(oldValue) + 1;
					} else {
						// Don't allow decrementing below zero
						if (oldValue > 1) {
							var newVal = parseFloat(oldValue) - 1;
						} else {
							newVal = 0;
						}
					}
					$button.parent().find("input").val(newVal);

					//
					let soLuong = lstBtnQty[index].value;
					if(isNaN(soLuong) || soLuong < 0) {
						let toast = document.querySelector(".toast");
						toast.querySelector(".toast-body").innerHTML = "Số lượng không hợp lệ";
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						return;
					}
					$.ajax({
					type: "POST",
					url: "/update-cart",
					dataType: "json",
					data: {
						_token: "{{ csrf_token() }}",
						soLuong: soLuong,
						sanphamId: lstBtnDelete[index].getAttribute("data-id")
					},
					success: function (response) {
						refreshEvent(response);	
					}
					});
				}));

				lstBtnDelete.forEach(item => item.addEventListener('click', function() {
					$.ajax({
					type: "POST",
					url: "/remove-cart",
					dataType: "json",
					data: {
						_token: "{{ csrf_token() }}",
						sanphamId: this.dataset.id
					},
					success: function (response) {
						refreshEvent(response);	
					}
					});
				}));
				
		} 

		
	});
</script>
@endsection
