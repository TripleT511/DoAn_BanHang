<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
    <title>@yield('title')</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

	
    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('css/bootstrap.custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
	@yield('css')

	<!-- SPECIFIC CSS -->
    <link href="{{ asset('css/home_1.css') }}" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<style>
		.toast {
				position: fixed;
				width: 350px;
				max-width: 100%;
				font-size: 0.9375rem;
				pointer-events: auto;
				background-color: #fff;
				background-clip: padding-box;
				border: 0 solid rgba(67, 89, 113, 0.1);
				box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
				border-radius: 0.5rem;
				z-index: 10000;
				right: 15px;
				transition: transform 0.3s ease-out, opacity 0.3s ease-out !important;
				-webkit-transition: transform 0.3s ease-out, opacity 0.3s ease-out !important;
				transform: translateX(calc(100% + 15px));
			}

			.toast.show {
				transform: translateX(0);
			}

			.toast.toast-success,
			.toast.toast-success .close-toast{
				background-color: #65c438;
			}

			.toast.toast-danger,
			.toast.toast-danger .close-toast {
				background-color: #de3c22;
			}

			.fade {
				transition: opacity 0.15s linear;
			}
		
			.toast-header {
				position: relative;
				display: flex;
				align-items: center;
				padding: 1.25rem 1.25rem;
					padding-bottom: 1.25rem;
				color: #fff;
				background-color: transparent;
				background-clip: padding-box;
				border-bottom: 0 solid transparent;
				border-top-left-radius: 0.5rem;
				border-top-right-radius: 0.5rem;
			}

			.close-toast {
				position: absolute;
				content: "";
				width: 30px;
				height: 30px;
				top: -15px;
				right: -15px;
				border-radius: 0.5rem;
				display: flex;
				align-items: center;
				justify-content: center;
				cursor: pointer;
			}

			.toast-header svg {
				width: 23px;
				height: 23px;
				fill: #fff;
				margin-right: 10px;
			}

			.close-toast svg {
				width: 18px;
				height: 18px;
				fill: #fff;
				margin-right: 0;
			}

			.toast-body {
				padding: 1.25rem;
				padding-top: 1.25rem;
				word-wrap: break-word;
				color: #fff;
				padding-top: 0;
			}

			

			.me-auto {
				margin-right: auto !important;
			}
			.fw-semibold {
				font-weight: 600 !important;
			}

			#lstItemCart {
				max-height: 300px;
				overflow-y: auto;
				overflow-x: hidden;
				scroll-snap-type: y mandatory;
			}

			#lstItemCart li {
				scroll-snap-align: start;
			}

			body::-webkit-scrollbar {
				width: 5px;
			}
				
			body::-webkit-scrollbar-thumb {
				background-color: #d7d7d7;
				outline: 1px solid #d7d7d7;
				border-radius: 20px;
			}
			.slick_wrapper {
    			position: relative;
			}

			.slick_wrapper .arrow.prev {
				left: -30px;
			}

			.slick_wrapper .arrow.next {
				right: -30px;
			}

			.slick_wrapper .arrow:hover {
				background-color: var(--theme-color);
			}

			.slick_wrapper:hover .arrow.prev {
				left: 0;
			}
			.slick_wrapper:hover .arrow {
				opacity: 1;
			}
			.slick_wrapper:hover .arrow.next {
				right: 0;
			}

			.slick_wrapper .arrow {
				position: absolute;
				top: 50%;
				transform: translateY(-50%);
				z-index: 100;
				width: 40px;
				height: 40px;
				line-height: 40px;
				text-align: center;
				background-color: #fff;
				cursor: pointer;
				color: #000;
				box-shadow: 0 0 10px rgb(0 0 0 / 10%);
				border-radius: 4px;
				opacity: 0;
				transition: all 0.5s ease-in-out;
			}
			.slick_carousel .slick-track {
				margin: 0 -10px;
			}

			.slick_carousel .slick-slide {
				margin: 0 10px;
			}

			.slick-list {
				overflow: visible;
			}
			.slick-track
			{
				display: flex !important;
			}

			.slick-slide
			{
				height: inherit !important;
			}

			ul {
				border-top: 0 !important;
			}

			.cate-item:hover > ul {
				display: block !important;
				background: #fff;
			}

			.info-user-login {
				display: flex !important;
				align-items: center;
				justify-content: center;
			}

			.info-user-login .img-avatar {
				width: 30px;
				height: 30px;
				border-radius: 50%;
				overflow: hidden;
			}
			.info-user-login .img-avatar img {
				width: 100%;
				height: 100%;
				object-fit: cover;
				display: flex;
				margin: auto;
			}
	</style>
</head>

<body>
	
	<div id="page">
		
	<header class="version_1">
		<div class="layer"></div><!-- Mobile menu overlay mask -->
		<div class="main_header">
			<div class="container">
				<div class="row small-gutters">
					<div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
						<div id="logo">
							<a href="{{ route('home') }}"><img src="{{ asset('img/logo.svg') }}" alt="" width="100" height="35"></a>
						</div>
					</div>
					<nav class="col-xl-6 col-lg-7">
						<a class="open_close" href="javascript:void(0);">
							<div class="hamburger hamburger--spin">
								<div class="hamburger-box">
									<div class="hamburger-inner"></div>
								</div>
							</div>
						</a>
						<!-- Mobile menu button -->
						<div class="main-menu">
							<div id="header_menu">
								<a href="{{ route('home') }}"><img src="img/logo_black.svg" alt="" width="100" height="35"></a>
								<a href="{{ route('home') }}" class="open_close" id="close_in"><i class="ti-close"></i></a>
							</div>
							<ul>
								<li>
									<a href="{{ route('home') }}" >Trang chủ</a>
								</li>
								<li>
									<a href="javascript:void(0);" >Giới thiệu</a>
								</li>
								<li>
									<a href="{{ route('san-pham') }}" >Sản phẩm</a>
								</li>
<?php 
function renderChildHeader($item)
{ 
	foreach($item as $value) { ?>
		<li>
			<a href="{{ route('danhmucsanpham', ['slug' => $value->slug]) }}">{{ $value->tenDanhMuc }}</a>
		</li>
<?php } 
}	
?>
								@foreach($lstDanhMucHeader as $item)
									<li class="megamenu submenu">
										<a href="{{ route('danhmucsanpham', ['slug' => $item->slug]) }}" class="show-submenu-mega">{{ $item->tenDanhMuc }}</a>
									
									@if(isset($item->childs) && count($item->childs) > 0)
									<div class="menu-wrapper">
										<div class="row small-gutters">
											@foreach($item->childs as $child)
												<div class="col-lg-3">
													<h3>{{ $child->tenDanhMuc }}</h3>
													@if(isset($child->childs) && count($child->childs) > 0)
													<ul>
														<?php renderChildHeader($child->childs); ?>
													</ul>
													@endif
												</div>
											@endforeach
											
										</div>
									<!-- /row -->
									</div>
										
									@endif
									</li>
								@endforeach
								<li>
									<a href="blog.html">Tin tức</a>
								</li>
							</ul>
						</div>
						<!--/main-menu -->
					</nav>
					<div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-right">
						<a class="phone_top" href="tel://9438843343"><strong><span>Cần trợ giúp?</span>+84 12-3456-789</strong></a>
					</div>
				</div>
				<!-- /row -->
			</div>
		</div>
		<!-- /main_header -->

		<div class="main_nav Sticky">
			<div class="container">
				<div class="row small-gutters">
					<div class="col-xl-3 col-lg-3 col-md-3">
						<nav class="categories">
							<ul class="clearfix">
								<li><span>
										<a href="{{ route('home') }}">
											<span class="hamburger hamburger--spin">
												<span class="hamburger-box">
													<span class="hamburger-inner"></span>
												</span>
											</span>
											Danh mục
										</a>
									</span>
									<div id="menu">
										<ul>
<?php 
function renderChild($item)
{ 
	foreach($item as $value) { ?>
		<li class="cate-item">
			<a href="{{ route('danhmucsanpham', ['slug' => $value->slug]) }}">{{ $value->tenDanhMuc }}</a>
				<?php if (isset($value->childs) && count($value->childs) > 0) { ?>
				<ul>
					<?php renderChild($value->childs); ?>
				</ul>
			<?php
		} ?>
		</li>
<?php } 
}	
?>
											@foreach($lstDanhMuc as $item)
												<li class="cate-item">
													<span>
														<a href="{{ route('danhmucsanpham', ['slug' => $item->slug]) }}">{{ $item->tenDanhMuc }}</a>
													</span>
													@if(isset($item->childs) && count($item->childs) > 0)
													<ul>
														<?php renderChild($item->childs); ?>
													</ul>
													@endif
												</li>
											@endforeach
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</div>
					<div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
						<div class="custom-search-input">
							<form action="{{ route('searchSanPham') }}" method="GET">
								<input type="text" name="keyword"  placeholder="Nhập sản phẩm bạn muốn tìm kiếm...">
								<button type="submit"><i class="header-icon_search_custom"></i></button>
							</form>
						</div>
					</div>
					<div class="col-xl-3 col-lg-2 col-md-3">
						<ul class="top_tools">
							<li>
								<div class="dropdown dropdown-cart">
									<a href="{{ route('gio-hang') }}" class="cart_bt"><strong>0</strong></a>
									<div class="dropdown-menu" >
										<ul id="lstItemCart">
											
										</ul>
										<div class="total_drop">
											<div class="clearfix"><strong>Tổng cộng: </strong><span></span></div>
											<a href="{{ route('gio-hang') }}" class="btn_1 outline">Xem giỏ hàng</a><a href="{{ route('checkout') }}" class="btn_1">Thanh toán</a>
										</div>
									</div>
								</div>
								<!-- /dropdown-cart-->
							</li>
							<li>
								<a href="#0" class="wishlist"><span>Sản phẩm yêu thích</span></a>
							</li>
							<li>
								<div class="dropdown dropdown-access">
									@guest
									<a href="#" class="info-user-login">
										<div class="img-avatar">
											<img src="{{ asset('storage/images/user-default.jpg') }}" alt="User">
										</div>
									</a>
									@endguest
									@auth
									<a href="{{ route('xem-thong-in-ca-nhan') }}" class="info-user-login">
										<div class="img-avatar online">
											@if(Auth()->user()->social_type != null)
											<img src="{{  Auth()->user()->anhDaiDien }}" alt="{{ Auth()->user()->hoTen }}">
											@else
											<img src="{{  asset('storage/'.Auth()->user()->anhDaiDien) }}" alt="{{ Auth()->user()->hoTen }}">
											@endif
										</div>
									</a>
									@endauth
									<div class="dropdown-menu">
										@guest
										<a href="{{ route('user.login') }}" class="btn_1">Đăng nhập</a>
										@endguest
										@auth
										<a href="{{ route('user.logout') }}" class="btn_1">Đăng xuất</a>
										@endauth
										<ul>
											<li>
												<a href="track-order.html"><i class="ti-truck"></i>Theo dõi đơn hàng</a>
											</li>
											@auth
											<li>
												<a href="{{ route('myOrder') }}"><i class="ti-package"></i>Đơn hàng của tôi</a>
											</li>
											<li>
												<a href="{{ route('xem-thong-in-ca-nhan') }}"><i class="ti-user"></i>Thông tin cá nhân</a>
											</li>
											@endauth
											<li>
												<a href="help.html"><i class="ti-help-alt"></i>Trợ giúp và câu hỏi</a>
											</li>
										</ul>
									</div>
								</div>
								<!-- /dropdown-access-->
							</li>
							<li>
								<a href="javascript:void(0);" class="btn_search_mob"><span>Tìm kiếm</span></a>
							</li>
							<li>
								<a href="#menu" class="btn_cat_mob">
									<div class="hamburger hamburger--spin" id="hamburger">
										<div class="hamburger-box">
											<div class="hamburger-inner"></div>
										</div>
									</div>
									Danh mục
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- /row -->
			</div>
			<div class="search_mob_wp">
				<input type="text" class="form-control" placeholder="Nhập từ khoá...">
				<input type="submit" class="btn_1 full-width" value="Search">
			</div>
			<!-- /search_mobile -->
		</div>
		<!-- /main_nav -->
	</header>
	<!-- /header -->
		
	@yield('content')
		
	<footer class="revealed">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_1">Liên kết</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_1">
						<ul>
							<li><a href="about.html">Về chúng tôi</a></li>
							<li><a href="help.html">Câu hỏi thường gặp</a></li>
							<li><a href="blog.html">Tin tức</a></li>
							<li><a href="contacts.html">Liên hệ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<h3 data-target="#collapse_2">Danh mục</h3>
					<div class="collapse dont-collapse-sm links" id="collapse_2">
						<ul>
							@foreach($lstDanhMuc as $item)
								<li><a href="{{ route('danhmucsanpham', ['slug' => $item->slug]) }}">{{ $item->tenDanhMuc }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-target="#collapse_3">Về chúng tôi</h3>
					<div class="collapse dont-collapse-sm contacts" id="collapse_3">
						<ul>
							<li><i class="ti-home"></i>65 Huỳnh Thúc Kháng, P.Bến Nghé, Q.1, Tp.HCM</li>
							<li><i class="ti-headphone-alt"></i>+84 12-3456-789</li>
							<li><i class="ti-email"></i><a href="#0">info@allaia.com</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
						<h3 data-target="#collapse_4">Hỗ trợ</h3>
					<div class="collapse dont-collapse-sm" id="collapse_4">
						<div id="newsletter">
						    <div class="form-group">
						        <input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Nhập email của bạn">
						        <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
						    </div>
						</div>
						<div class="follow_us">
							<h5>Theo dõi</h5>
							<ul>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/twitter_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/facebook_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/instagram_icon.svg" alt="" class="lazy"></a></li>
								<li><a href="#0"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/youtube_icon.svg" alt="" class="lazy"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /row-->
			<hr>
			<div class="row add_bottom_25">
				<div class="col-lg-6">
					<ul class="footer-selector clearfix">
						<li>
							<div class="styled-select lang-selector">
								<select>
									<option value="Tiếng Việt" selected>Tiếng Việt</option>
									<option value="French">French</option>
									<option value="English">English</option>
									<option value="Russian">Russian</option>
								</select>
							</div>
						</li>
						<li>
							<div class="styled-select currency-selector">
								<select>
									<option value="VNĐ" selected>VNĐ</option>
									<option value="US Dollars">US Dollars</option>
								</select>
							</div>
						</li>
						<li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-src="img/cards_all.svg" alt="" width="198" height="30" class="lazy"></li>
					</ul>
				</div>
				<div class="col-lg-6">
					<ul class="additional_links">
						<li><a href="#0">Các điều khoản</a></li>
						<li><a href="#0">Chính sách</a></li>
						<li><span>© 2020 Allaia</span></li>
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!--/footer-->
	</div>
	<!-- page -->
	
	<div id="toTop"></div><!-- Back to top button -->

	{{-- <div class="popup_wrapper">
		<div class="popup_content">
			<span class="popup_close">Close</span>
			<a href="listing-grid-1-full.html"><img class="img-fluid" src="img/banner_popup.png" alt="" width="500" height="500"></a>
		</div>
	</div> --}}
	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>
	@yield('js')

	<!-- SPECIFIC SCRIPTS -->
	<script src="{{ asset('js/carousel-home.min.js') }}"></script>

</body>
</html>