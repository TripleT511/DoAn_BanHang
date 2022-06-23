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
										<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Max 720 Sage Low</h2>
										<p class="owl-slide-animated owl-slide-subtitle">
											Limited items available at this price
										</p>
										<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
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
			<li>
				<a href="#0" class="img_container">
					<img src="img/banners_cat_placeholder.jpg" data-src="img/banner_1.jpg" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Men's Collection</h3>
						<div><span class="btn_1">Shop Now</span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="#0" class="img_container">
					<img src="img/banners_cat_placeholder.jpg" data-src="img/banner_2.jpg" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Womens's Collection</h3>
						<div><span class="btn_1">Shop Now</span></div>
					</div>
				</a>
			</li>
			<li>
				<a href="#0" class="img_container">
					<img src="img/banners_cat_placeholder.jpg" data-src="img/banner_3.jpg" alt="" class="lazy">
					<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
						<h3>Kids's Collection</h3>
						<div><span class="btn_1">Shop Now</span></div>
					</div>
				</a>
			</li>
		</ul>
		<!--/banners_grid -->
		
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Top Sản phẩm bán chạy</h2>
				<span>Products</span>
				<p>Những sản phẩm bán chạy nhất</p>
			</div>
			<div class="row small-gutters">
				@foreach ($lstSanPhamNoiBat as $key => $item)
				<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure>
							<span class="ribbon off">-30%</span>
							<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							@foreach ($item->hinhanhs as $key => $item2)
								<img class="img-fluid lazy" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="{{ $item->tenSanPham }}">
                            @endforeach
								
								
							</a>
							<div data-countdown="2019/05/15" class="countdown"></div>
						</figure>
						<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
						<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							<h3>{{ $item->tenSanPham }}</h3>
						</a>
						<div class="price_box">
							<span class="new_price">{{ $item->gia }} đ</span>
							@if($item->giaKhuyenMai != 0)
								<span class="old_price">{{ $item->giaKhuyenMai }} đ</span>
							@endif
						</div>
						<ul>
							<li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="ti-shopping-cart"></i><span>Thêm vào giỏ hàng</span></a></li>
						</ul>
					</div>
					<!-- /grid_item -->
				</div>
				
				@endforeach
				<!-- /col -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<div class="featured lazy" data-bg="url(img/featured_home.jpg)">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
				<div class="container margin_60">
					<div class="row justify-content-center justify-content-md-start">
						<div class="col-lg-6 wow" data-wow-offset="150">
							<h3>Armor<br>Air Color 720</h3>
							<p>Lightweight cushioning and durable support with a Phylon midsole</p>
							<div class="feat_text_block">
								<div class="price_box">
									<span class="new_price">$90.00</span>
									<span class="old_price">$170.00</span>
								</div>
								<a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /featured -->

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Đánh giá Cao</h2>
				<span>Đánh giá Cao</span>
				<p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
			</div>
			<div class="owl-carousel owl-theme products_carousel">
				@foreach ($lstSanPham as $key=>$item)
				<div class="item">
					<div class="grid_item">
						@if($item->dacTrung == 1)
						<span class="ribbon new">New</span>
						@elseif($item->dacTrung == 2)
						<span class="ribbon hot">Hot</span>
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
						<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
						<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							<h3>{{ $item->tenSanPham }}</h3>
						</a>
						<div class="price_box">
							<span class="new_price">${{ $item->gia }}</span>
						</div>
						<ul>
							<li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="ti-shopping-cart"></i><span>Thêm vào giỏ hàng</span></a></li>
						</ul>
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

		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Tin Mới Nhất</h2>
				<span>Blog</span>
				<p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<a class="box_news" href="blog.html">
						<figure>
							<img src="img/blog-thumb-placeholder.jpg" data-src="img/blog-thumb-1.jpg" alt="" width="400" height="266" class="lazy">
							<figcaption><strong>28</strong>Dec</figcaption>
						</figure>
						<ul>
							<li>Bởi Mark Twain</li>
							<li>20.11.2017</li>
						</ul>
						<h4>UNIQLO giới thiệu dự án PEACE FOR ALL với mục đích thiện nguyện</h4>
						<p>Dự án PEACE FOR ALL như một cầu nối để mỗi cá nhân thể hiện thông điệp và thế giới quan độc đáo của riêng mình. Được thực hiện dựa trên mối quan hệ hợp tác giữa UNIQLO với các tên tuổi hàng đầu thế giới trong các lĩnh vực bao gồm:...</p>
					</a>
				</div>
				<!-- /box_news -->
				<div class="col-lg-6">
					<a class="box_news" href="blog.html">
						<figure>
							<img src="img/blog-thumb-placeholder.jpg" data-src="img/blog-thumb-2.jpg" alt="" width="400" height="266" class="lazy">
							<figcaption><strong>28</strong>Dec</figcaption>
						</figure>
						<ul>
							<li>Bởi Jhon Doe</li>
							<li>20.11.2017</li>
						</ul>
						<h4>UNIQLO giới thiệu dự án PEACE FOR ALL với mục đích thiện nguyện</h4>
						<p>Dự án PEACE FOR ALL như một cầu nối để mỗi cá nhân thể hiện thông điệp và thế giới quan độc đáo của riêng mình. Được thực hiện dựa trên mối quan hệ hợp tác giữa UNIQLO với các tên tuổi hàng đầu thế giới trong các lĩnh vực bao gồm:...</p>
					</a>
				</div>
				<!-- /box_news -->
				<div class="col-lg-6">
					<a class="box_news" href="blog.html">
						<figure>
							<img src="img/blog-thumb-placeholder.jpg" data-src="img/blog-thumb-3.jpg" alt="" width="400" height="266" class="lazy">
							<figcaption><strong>28</strong>Dec</figcaption>
						</figure>
						<ul>
							<li>Bởi Luca Robinson</li>
							<li>20.11.2017</li>
						</ul>
						<h4>UNIQLO giới thiệu dự án PEACE FOR ALL với mục đích thiện nguyện</h4>
						<p>Dự án PEACE FOR ALL như một cầu nối để mỗi cá nhân thể hiện thông điệp và thế giới quan độc đáo của riêng mình. Được thực hiện dựa trên mối quan hệ hợp tác giữa UNIQLO với các tên tuổi hàng đầu thế giới trong các lĩnh vực bao gồm:...</p>
					</a>
				</div>
				<!-- /box_news -->
				<div class="col-lg-6">
					<a class="box_news" href="blog.html">
						<figure>
							<img src="img/blog-thumb-placeholder.jpg" data-src="img/blog-thumb-4.jpg" alt="" width="400" height="266" class="lazy">
							<figcaption><strong>28</strong>Dec</figcaption>
						</figure>
						<ul>
							<li>Bởi Luca Robinson</li>
							<li>20.11.2017</li>
						</ul>
						<h4>UNIQLO giới thiệu dự án PEACE FOR ALL với mục đích thiện nguyện</h4>
						<p>Dự án PEACE FOR ALL như một cầu nối để mỗi cá nhân thể hiện thông điệp và thế giới quan độc đáo của riêng mình. Được thực hiện dựa trên mối quan hệ hợp tác giữa UNIQLO với các tên tuổi hàng đầu thế giới trong các lĩnh vực bao gồm:...</p>
					</a>
				</div>
				<!-- /box_news -->
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
					document.querySelector(".total_drop div span").innerHTML = response.total;
					document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
				}
			});
		});
		
	</script>
@endsection