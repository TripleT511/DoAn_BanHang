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
</style>
@endsection
@section('content')

<main class="bg_gray">
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
		<!-- /page_header -->
		<table class="table table-striped cart-list">
							<thead>
								<tr>
									<th>
										Sản phẩm
									</th>
									<th>
										Giá
									</th>
									<th>
										Số lượng
									</th>
									<th>
										Tổng
									</th>
									<th>
										
									</th>
								</tr>
							</thead>
							<tbody>
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
										<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
									</td>
									<td>
										<strong>{{ number_format($item['tongTien'], 0, '', ',')}}  ₫</strong>
									</td>
									<td class="options">
										<a href="#"><i class="ti-trash"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>

						<div class="row add_top_30 flex-sm-row-reverse cart_actions">
						<div class="col-sm-4 text-right">
							<button type="button" class="btn_1 gray">Cập nhật</button>
						</div>
							<div class="col-sm-8">
							<div class="apply-coupon">
								<div class="form-group form-inline">
									<input type="text" name="coupon-code" value="" placeholder="Promo code" class="form-control"><button type="button" class="btn_1 outline">Apply Coupon</button>
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
			<ul>
				<li>
					<span>Tổng tiềm</span> $240.00
				</li>
				<li>
					<span>Phí giao hàng</span> $7.00
				</li>
				<li>
					<span>Tổng</span> $247.00
				</li>
			</ul>
			<a href="#" class="btn_1 full-width cart">Thanh Toán</a>
					</div>
				</div>
			</div>
		</div>
		<!-- /box_cart -->
		
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
	});
</script>
@endsection
