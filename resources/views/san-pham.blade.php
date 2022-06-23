@extends('layouts.user')

@section('title','Danh sách sản phẩm')

@section('css')

<link href="{{ asset('css/listing.css') }}" rel="stylesheet">

@endsection
@section('content')
<main>
		<div class="top_banner">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.3)">
				<div class="container">
					<div class="breadcrumbs">
						<ul>
							<li><a href="#">Trang chủ</a></li>
							<li><a href="#">Category</a></li>
							<li>Page active</li>
						</ul>
					</div>
					<h1>Shoes - Grid listing</h1>
				</div>
			</div>
			<img src="img/bg_cat_shoes.jpg" class="img-fluid" alt="">
		</div>
		<!-- /top_banner -->
		
		<div id="stick_here"></div>		
		<div class="toolbox elemento_stick">
			<div class="container">
			<ul class="clearfix">
				<li>
					<div class="sort_select">
						<select name="sort" id="sort">
								<option value="popularity" selected="selected">Sắp xếp</option>
								<option value="rating">Sắp xếp theo đánh giá</option>
								<option value="date">Sắp xếp theo sản phẩm mới</option>
								<option value="price">Sắp xếp theo giá: thấp tới cao</option>
								<option value="price-desc">Sắp xếp theo giá: thấp tới cao tới thấp
						</select>
					</div>
				</li>
				<li>
					<a href="#0"><i class="ti-view-grid"></i></a>
					<a href="listing-row-1-sidebar-left.html"><i class="ti-view-list"></i></a>
				</li>
				<li>
					<a data-toggle="collapse" href="#filters" role="button" aria-expanded="false" aria-controls="filters">
						<i class="ti-filter"></i><span>Lọc</span>
					</a>
				</li>
			</ul>
			<div class="collapse" id="filters"><div class="row small-gutters filters_listing_1">
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="dropdown">
					<a href="#" data-toggle="dropdown" class="drop">Danh mục</a>
					<div class="dropdown-menu">
						<div class="filter_type">
								<ul>
									<li>
										<label class="container_check">Nam <small>12</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Nữ <small>24</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Bán chạy <small>23</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Bán thử <small>11</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
								</ul>
								<a href="#0" class="apply_filter">áp dụng</a>
							</div>
					</div>
				</div>
				<!-- /dropdown -->
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="dropdown">
					<a href="#" data-toggle="dropdown" class="drop">Màu</a>
					<div class="dropdown-menu">
						<div class="filter_type">
								<ul>
									<li>
										<label class="container_check">Xanh dương <small>06</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Đỏ <small>12</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Cam <small>17</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Đen <small>43</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
								</ul>
								<a href="#0" class="apply_filter">áp dụng</a>
							</div>
					</div>
				</div>
				<!-- /dropdown -->
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="dropdown">
					<a href="#" data-toggle="dropdown" class="drop">Nhãn hiệu</a>
					<div class="dropdown-menu">
						<div class="filter_type">
								<ul>
									<li>
										<label class="container_check">Adidas <small>11</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Nike <small>08</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Vans <small>05</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">Puma <small>18</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
								</ul>
								<a href="#0" class="apply_filter">áp dụng</a>
							</div>
					</div>
				</div>
				<!-- /dropdown -->
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="dropdown">
					<a href="#" data-toggle="dropdown" class="drop">Giá tiền</a>
					<div class="dropdown-menu">
						<div class="filter_type">
								<ul>
									<li>
										<label class="container_check">300.000 — 1.000.000vnđ<small>11</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">1.000.000 — 2.000.000vnđ<small>08</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">2.000.000 — 3.000.000vnđ<small>05</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
									<li>
										<label class="container_check">3.000.000 — 5.000.000vnđ<small>18</small>
										  <input type="checkbox">
										  <span class="checkmark"></span>
										</label>
									</li>
								</ul>
								<a href="#0" class="apply_filter">áp dụng</a>
							</div>
					</div>
				</div>
				<!-- /dropdown -->
		
			</div></div></div>
			</div>
		</div>
			<!-- /toolbox -->

			<div class="container margin_30">
			 <div class="row small-gutters">
				@foreach ($lstSanPham as $key=> $item)
				<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure>
							<span class="ribbon off">-{{$item->giaKhuyenMai}}đ</span>
							<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
								@foreach ($item->hinhanhs as $key => $item2)
								<img class="img-fluid lazy" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="{{ $item->tenSanPham }}">
								@endforeach
							</a>
							<div data-countdown="2019/05/15" class="countdown"></div>
						</figure>
						<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
							<h3>{{$item->tenSanPham}}</h3>
						</a>
						<div class="price_box">
							<span class="new_price">{{$item->gia}}đ</span>
							<span class="old_price">110000đ</span>
						</div>
						<ul>
							{{-- <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
							<li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li> --}}
							<li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Thêm vào giỏ hàng"><i class="ti-shopping-cart"></i><span>thêm vào giỏ hàng</span></a></li>
						</ul>
					</div>
					<!-- /grid_item -->
				</div>
				@endforeach
			 </div>	
			
				<div class="pagination__wrapper">
					<ul class="pagination">
						{!!$lstSanPham->links() !!}
					</ul>
				</div>
				
			 {{-- <div class="pagination__wrapper">
				<ul class="pagination">
					<li><a href="" class="prev" title="previous page">&#10094;</a></li>
					<li>
						<a href="" class="active">1</a>
					</li>
					<li>
						<a href="">2</a>
					</li>
					<li>
						<a href="">3</a>
					</li>
					<li>
						<a href="">4</a>
					</li>
					<li><a href="" class="next" title="next page">&#10095;</a></li>
				</ul>
			</div> --}}
				
		</div>
		<!-- /container -->
	</main>

@endsection