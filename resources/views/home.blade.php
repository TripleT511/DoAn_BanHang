@extends('layouts.user')

@section('title','Trang chủ')

@section('content')
<main>
		<div id="carousel-home">
			<div class="owl-carousel owl-theme">
			 @foreach ($lstSlider as $item)
			 @if($item->trangThai == 1)
				<div class="owl-slide cover" style="background-image: url({{ asset('storage/'.$item->hinhAnh) }});">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<div class="container">
							<div class="row justify-content-center justify-content-md-end">
								<div class="col-lg-6 static">
									<div class="slide-text text-right white">
										<h2 class="owl-slide-animated owl-slide-title">{{ $item->tieuDe }}</h2>
										<div class="owl-slide-animated owl-slide-cta">
											<a class="btn_1" href="{{ route('slider', ['slug'=> $item->slug]) }}" role="button">Xem thêm</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
				<!--/owl-slide-->
			 @endforeach
			</div>
			<div id="icon_drag_mobile"></div>
		</div>
		<!--/carousel-->

		<ul id="banners_grid" class="clearfix">
			@foreach($lstDanhMuc as $key => $item)
				@php
				if($key == 3) break;
				@endphp
				<li>
					<a href="{{ route('danhmucsanpham', ['slug' => $item->slug]) }}" class="img_container">
						<img src="{{ asset('storage/'.$item->hinhAnh) }}" data-src="{{ asset('storage/'.$item->hinhAnh) }}" alt="" class="lazy">
						<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
							<h3>{{ $item->tenDanhMuc }}</h3>
							<div><span class="btn_1">Xem thêm</span></div>
						</div>
					</a>
				</li>
			@endforeach
			
		</ul>
		<!--/banners_grid -->
		
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Top Sản phẩm bán chạy</h2>
				<span>Products</span>
				<p>Những sản phẩm bán chạy nhất</p>
			</div>
			<div class="row small-gutters">
				@foreach ($lstSanPhamBanChay as $key => $item)
				<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure>
							@if($item->giaKhuyenMai != 0)
								<span class="ribbon off">-{{ round((($item->gia-$item->giaKhuyenMai) /$item->gia) * 100) }}%</span>
							@else
								@if($item->dacTrung == 1)
									<span class="ribbon new">Bán chạy</span>
									@elseif($item->dacTrung == 2)
									<span class="ribbon hot">Hot</span>
								@endif
							@endif
							<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							@foreach ($item->hinhanhs as $key => $item2)
								<img class="img-fluid lazy" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="{{ $item->tenSanPham }}">
                            @endforeach
								
							</a>
						</figure>
						<div class="rating">
							@php
								$starActive = round($item->danhgias->avg('xepHang'));
								$starNonActive = 5 - $starActive;
							@endphp
							@for ($i = 0; $i < $starActive; $i++)
								<i class="icon-star voted"></i>
							@endfor
							@for ($i = 0; $i < $starNonActive; $i++)
								<i class="icon-star"></i>
							@endfor
						</div>
						<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							<h3>{{ $item->tenSanPham }}</h3>
						</a>
						<div class="price_box">
							@if($item->giaKhuyenMai == 0)
							<span class="new_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
							@elseif($item->giaKhuyenMai != 0)
							<span class="new_price">{{ number_format($item->giaKhuyenMai, 0, '', ',') }} đ</span>
							<span class="old_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
							@endif
						</div>
					</div>
					<!-- /grid_item -->
				</div>
				
				@endforeach
				<!-- /col -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<div class="featured lazy" style="background: url({{ asset('img/banner.png') }}); height: 330px;background-size: cover !important;
		background-position: center !important;
		background-repeat: no-repeat !important; ">
		</div>
		<!-- /featured -->

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Sản phẩm nổi bật</h2>
				<span>Products</span>
				<p>Những sản phẩm hot của shop</p>
			</div>
			<div class="owl-carousel owl-theme products_carousel">
				@foreach ($lstSanPhamNoiBat as $key=>$item)
				<div class="item">
					<div class="grid_item">
						@if($item->giaKhuyenMai != 0)
								<span class="ribbon off">-{{ round((($item->gia-$item->giaKhuyenMai) /$item->gia) * 100) }}%</span>
							@else
								@if($item->dacTrung == 1)
									<span class="ribbon new">Bán chạy</span>
									@elseif($item->dacTrung == 2)
									<span class="ribbon hot">Hot</span>
								@endif
						@endif
						<figure>
							<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							@foreach ($item->hinhanhs as $key => $item2)
                              @if($key == 1) <?php break; ?> @endif
                                <img src="{{ asset('storage/'.$item2->hinhAnh) }}" class="image-product" alt="{{ $item->tenSanPham }}">
								<img class="owl-lazy" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="{{ $item->tenSanPham }}">
                            @endforeach
							</a>
						</figure>
						<div class="rating">
							@php
								$starActive = round($item->danhgias->avg('xepHang'));
								$starNonActive = 5 - $starActive;
							@endphp
							@for ($i = 0; $i < $starActive; $i++)
								<i class="icon-star voted"></i>
							@endfor
							@for ($i = 0; $i < $starNonActive; $i++)
								<i class="icon-star"></i>
							@endfor
						</div>
						<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							<h3>{{ $item->tenSanPham }}</h3>
						</a>
						<div class="price_box">
							@if($item->giaKhuyenMai == 0)
							<span class="new_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
							@elseif($item->giaKhuyenMai != 0)
							<span class="new_price">{{ number_format($item->giaKhuyenMai, 0, '', ',') }} đ</span>
							<span class="old_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
							@endif
						</div>
						
					</div>
					<!-- /grid_item -->
				</div>
				<!-- /item -->
				@endforeach
				
			</div>
			<!-- /products_carousel -->
		</div>
		<!-- /container -->
		
		<div class="bg_gray">
			<div class="container margin_30">
				<div id="brands" class="owl-carousel owl-theme">
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_1.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_2.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_3.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_4.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_5.png" alt="" class="owl-lazy"></a>
					</div><!-- /item -->
					<div class="item">
						<a href="#0"><img src="img/brands/placeholder_brands.png" data-src="img/brands/logo_6.png" alt="" class="owl-lazy"></a>
					</div><!-- /item --> 
				</div><!-- /carousel -->
			</div><!-- /container -->
		</div>
		<!-- /bg_gray -->

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
					document.querySelector(".total_drop div span").innerHTML = response.total;
					document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
					abc();

				}
			});
		});

		function abc() {
			let lstBtnDelete = document.querySelectorAll(".btn-trash");
		// Xoá giỏ hàng //
		lstBtnDelete.forEach(item => item.addEventListener('click', function() {
			console.log("a");
			$.ajax({
			type: "POST",
			url: "/remove-cart",
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				sanphamId: this.dataset.id
			},
			success: function (response) {
				$.ajax({
				type: "GET",
				url: "/render-cart",
				dataType: "json",
				success: function (response) {
					$("#lstItemCart").html(response.newCart);
					document.querySelector(".total_drop div span").innerHTML = response.total;
					document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
					abc();

				}
			});
			}
			});
		}));
		}
		
	</script>
@endsection