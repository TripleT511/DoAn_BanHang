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

	.coupon-wrapper {
		width: 100%;
		padding: 10px;
		background: #fff;
    	border-radius: 7px;
		overflow: visible;
	}

	.coupon-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
	}

	.coupon-header p {
		margin: 0;
	}

	.coupon-list {
		padding: 20px 0 50px;
		max-height: 270px;
		overflow: visible; 
	}

	.coupon-item {
		position: relative;
		display: flex;
		width: 100%;
		background: #fff;
		margin: 0 10px 0 0;
		scroll-snap-align: start;
		box-shadow: 0 2px 6px 0 rgb(67 89 113 / 12%);
		border-radius: 7px;
		height: 100%;
	}

	.info {
		position: absolute;
		content: "";
		width: 20px;
		height: 20px;
		top: 10px;
		right: 10px;
		border-radius: 50%;
		text-align: center;
		border: 1px solid #004dda;
		font-size: 13px;
		color: #004dda;
		cursor: pointer;
	}

	.coupon-item .img {
		position: relative;
		width: 100px;
    	height: 100%;
		padding: 10px;
		margin: auto;
		border-right: 2px dashed #d7d7d7;
	}

	.coupon-item .img:after,
    .coupon-item .img:before {
        position: absolute;
        content: "";
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50%;
        right: -11.5px;
    }

    .coupon-item .img:after {
        bottom: -10px;
        box-shadow: inset 0 4px 3px -1px rgb(67 89 113 / 10%);
    }
      
    .coupon-item .img::before {
        top: -10px;
        box-shadow: inset 0px -2px 6px -3px rgb(67 89 113 / 12%);
    }

	.coupon-item .img img {
		width: 100%;
		height: 100%;
		margin: auto;
		object-fit: contain;
		display: flex;
	}

	.coupon-item .coupon-content {
		flex: 0 0 calc(100% - 100px);
   		width: calc(100% - 100px);
		padding: 10px 33px 10px 10px;
		display: flex;
		flex-direction: column;
    	justify-content: space-between;
	}

	.coupon-item .coupon-content p {
		margin: 0;
	}

	.coupon-item .code {
		font-weight: bold;
	}

	.coupon-item .coupon-content .title{
		display: -webkit-box;
		-webkit-line-clamp: 1;
		-webkit-box-orient: vertical;  
		overflow: hidden;
	}
	.coupon-item .coupon-content .des {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;  
		overflow: hidden;
	}

	.coupon-item .coupon-content .title {
		font-weight: bold;
	}

	.coupon-item .info + .info-content {
		position: absolute;
		content: "";
		width: 100%;
		background: #fff;
		left: 50%;
		transform: translateX(-50%);
		border-radius: 7px;
		z-index: 10;
		box-shadow: 0 2px 6px 0 rgb(67 89 113 / 12%);
		padding: 10px;
		visibility: hidden;
    	opacity: 0;
		transition: all .3s ease-out;
		-webkit-transition: all .3s ease-out;
	}

	.coupon-item .info:hover + .info-content,
	.coupon-item .info + .info-content:hover {
		visibility: visible;
    	opacity: 1;
	}

	.info-content > div {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
	}
	.info-content p {
		margin-bottom: 10px;
	}
	.info-content > div:last-of-type p {
		margin: 0;
	}

	.info-content .title {
		flex: 0 0 70px;
		width: 70px;
		text-align: left;
	}

	.info-content .title + p {
		flex: 1;
		text-align: left;
	}

	.info-content > div:last-of-type .title {
		flex: 0 0 100%;
	}

	.copy {
		border-radius: 50%;
		padding: 5px;
		border: 1px solid #004dda;
		width: 30px;
		height: 30px;
		text-align: center;
		cursor: pointer;
		background-color:rgb(0 77 218 / 5%);
	}
	.copy i {
		font-size: 16px;
    	color: #004dda;
	}
	.slick_wrapper { 
		padding: 0 50px;
		overflow: hidden;
	}
	.slick_carousel .slick-track {
		padding-bottom: 50px;
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
					<h6 class="title">Mã giảm giá</h6>
					<div class="apply-coupon">
						<div class="form-group form-inline">
							<input type="text" name="coupon-code" id="couponCode" value="" placeholder="Nhập mã giảm giá" class="form-control"><button type="button" class="btn_1 outline btn-add-discount">Áp dụng</button>
						</div>
					</div>
					<div class="coupon-wrapper">
						<div class="coupon-header">
							<p>Mã giảm giá hiện có </p>
							<p>Áp dụng tối đa: 1</p>
						</div>
						<section class="slick_wrapper">
							<div class="arrow_box" id="discount_btn">
								<div class="prev arrow"><i class="fas fa-chevron-left"></i></div>
								<div class="next arrow"><i class="fas fa-chevron-right"></i></div>
							</div>
							<div class="coupon-list slick_carousel">
							@foreach ($lstDiscount as $discount)
							<div class="item">
								<div class="coupon-item">
									<div class="img">
										<img src="{{ asset('storage/'.$discount->hinhAnh) }}" alt="{{ $discount->tenMa }}">
									</div>
									<div class="coupon-content">
										<div class="header">
											<p class="title">
											{{ $discount->tenMa }} 
											@if($discount->mucGiamToiDa != null)<span style="font-weight: normal;">(tối đa {{(float)$discount->mucGiamToiDa / 1000 }}K)</span> 
											@endif
										</p>
										<p class="des">
											Áp dụng cho đơn hàng từ {{number_format($discount->giaTriToiThieu, 0, '', ',') }} ₫
										</p>
										</div>
										<p class="date">
											HSD: {{ date('d-m-Y', strtotime($discount->ngayKetThuc)) }}
										</p>
									</div>
									<div class="info">
										<span>i</span>
									</div>
									<div class="info-content">
										<div class="header">
											<p class="title">Mã: </p>
											<p class="code">
												{{ $discount->code }}
												<div class="copy" data-code="{{ $discount->code }}">
													<i class="fas fa-copy"></i>
												</div>
											</p>
										</div>
										<div class="description">
											<p class="title">Điều kiện: </p>
											{!! $discount->moTa !!}
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						</section>
						
					</div>
				</div>
			</div>
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
					<span>Giảm giá:</span> <p class="discount" style="margin: 0;">  0 ₫</p> 
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
	$(function(){
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

		// Slick Carousel Discount
		$('.slick_carousel').slick({
			dots: false,
			rows: 1,
			arrows: false,
			infinite: true,
			autoplay: false,
			autoplaySpeed: 3000,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 1,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 2,
					}
				},
				{
					breakpoint: 568,
					settings: {
						slidesToShow: 1,
					}
				}

			]
		});
		$('#discount_btn '+'.next').click(function() {
                $(".slick_carousel").slick('slickNext');
            });
		$('#discount_btn '+' .prev').click(function() {
			$(".slick_carousel").slick('slickPrev');
		});
		// Slick Carousel Discount

		let btnCopyCode = document.querySelectorAll(".copy");
		btnCopyCode.forEach(item => item.addEventListener("click", () => {
			navigator.clipboard.writeText(item.dataset.code);
			$("#couponCode").val(item.dataset.code);
			let toast = document.querySelector(".toast");
			toast.querySelector(".toast-body").innerHTML = "Mã giảm giá được sao chép thành công";
			toast.classList.remove("toast-danger");
			toast.classList.add("toast-success", "show");
			setTimeout(() => {
				toast.classList.remove("show");
				}, 1000);
			return;
		}));

		// Áp dụng mã giảm giá
		let btnAddDiscount = document.querySelector('.btn-add-discount');
		btnAddDiscount.addEventListener('click', function() {
			let code = $("#couponCode").val();
			if (code == '') {
				return;
			}
			$.ajax({
				type: "POST",
				url: "/add-discount-code",
				data: {
					_token: "{{ csrf_token() }}",
					code: $("#couponCode").val(),
					total: {{ $total}}
				},
				dataType: "json",
				success: function (response) {
					let toast = document.querySelector(".toast");
					if(response.error) {
						toast.querySelector(".toast-body").innerHTML = response.error;
						toast.classList.remove("toast-success");
						toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
							return;
					}
					if(response.success) {
						toast.querySelector(".toast-body").innerHTML = response.success;
						toast.classList.remove("toast-danger");
						toast.classList.add("toast-success", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						refreshEvent(response);	
					}
				}
			});
		});


		// Áp dụng mã giảm giá

		let lstBtnDelete = document.querySelectorAll(".btn-trash");
		let lstBtnIncre = document.querySelectorAll(".inc.button_inc");
		let lstBtnDecre = document.querySelectorAll(".dec.button_inc");
		let lstBtnQty = document.querySelectorAll(".qty2");

		// Câp nhật số lượng sản phẩm trong giỏ hàng //
		lstBtnIncre.forEach((item, index) => item.addEventListener('click', function() {
			
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
				let toast = document.querySelector(".toast");
				if(response.error) {
						toast.querySelector(".toast-body").innerHTML = response.error;
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
				}
				refreshEvent(response);	
			}
			});
		}));

		lstBtnDecre.forEach((item, index) => item.addEventListener('click', function() {
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
				
				if(response.error) {
						let toast = document.querySelector(".toast");
						toast.querySelector(".toast-body").innerHTML = response.error;
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
				}
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
					document.querySelector(".cart-total").innerHTML = `${response.newTotal} ₫`;
				}


				// Nếu có mã giảm giá
				if(response.discount) {
					document.querySelector(".discount").innerHTML =`-${response.discount} ₫`;
				}

				//
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
						if(response.error) {
						let toast = document.querySelector(".toast");
						toast.querySelector(".toast-body").innerHTML = response.error;
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						}
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
						if(response.error) {
						let toast = document.querySelector(".toast");
						toast.querySelector(".toast-body").innerHTML = response.error;
						toast.classList.remove("toast-success");
							toast.classList.add("toast-danger", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						}
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
