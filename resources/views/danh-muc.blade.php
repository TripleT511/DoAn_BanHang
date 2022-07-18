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
							<li><a href="{{ route('home') }}">Trang chủ</a></li>
							<li>Sản phẩm</li>
						</ul>
					</div>
					<h1>Sản phẩm</h1>
				</div>
			</div>
			<img src="{{ asset('img/banner.png') }}" class="img-fluid" alt="Banner">
		</div>
		<!-- /top_banner -->
		
		<div id="stick_here"></div>		
		<div class="toolbox elemento_stick">
			<div class="container">
				
					<ul class="clearfix">
						<li>
							<div class="sort_select">
								<form action="{{ route('danhmucsanpham', ['slug' => $slug ? $slug : '']) }}" method="GET">
								<input name="danhmuc" value="{{ $danhmuc ? $danhmuc : ''}}" type="hidden">
								<input type="hidden" name="page" value="{{ $lstSanPham->currentPage() }}">
								<input name="price" value="{{ $price ? $price : ''}}" type="hidden">
								<select onchange="this.form.submit()" name="sort" id="sort">
										<option selected="selected">Sắp xếp</option>
										<option value="rating">Sắp xếp theo đánh giá</option>
										<option value="date">Sắp xếp theo sản phẩm mới</option>
										<option value="price">Sắp xếp theo giá: thấp tới cao</option>
										<option value="pricedesc">Sắp xếp theo giá: cao tới thấp </option>
								</select>
								</form>
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
					<a href="{{ route('home') }}" data-toggle="dropdown" class="drop">Danh mục</a>
					<div class="dropdown-menu">
						<div class="filter_type">
							<form action="{{ route('danhmucsanpham',  ['slug' => $slug ? $slug : '']) }}" method="GET">
							<input type="hidden" name="page" value="{{ $lstSanPham->currentPage() }}">
							<input name="sort" value="{{ $sort ? $sort : ''}}" type="hidden">
							<input name="price" value="{{ $price ? $price : ''}}" type="hidden">
							<ul>
								@foreach($lstDanhMuc as $item)
									<li>
										<label class="container_check">{{ $item->tenDanhMuc}}
											<input {{ $danhmuc == $item->id ? 'checked' : '' }} onchange="this.form.submit()" name="danhmuc" value="{{ $item->id}}" type="checkbox">
											<span class="checkmark"></span>
										</label>
									</li>
								@endforeach
							</ul>
							</form>
						</div>
					</div>
				</div>
				<!-- /dropdown -->
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="dropdown">
					<a href="{{ route('home') }}" data-toggle="dropdown" class="drop">Giá tiền</a>
					<div class="dropdown-menu">
						<div class="filter_type">
							<form action="{{ route('danhmucsanpham',  ['slug' => $slug ? $slug : '']) }}" method="GET">
							<input type="hidden" name="page" value="{{ $lstSanPham->currentPage() }}">
							<input name="sort" value="{{ $sort ? $sort : ''}}" type="hidden">
							<ul>
								<li>
									<label class="container_check">Dưới 300.000 đ
										<input {{ $price == "duoi3" ? 'checked' : '' }} onchange="this.form.submit()" type="radio" value="duoi3" name="price">
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label class="container_check">Từ 300.000 — 500.000 đ
										<input  {{ $price == "3den5" ? 'checked' : '' }} onchange="this.form.submit()" value="3den5" type="radio" name="price">
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label class="container_check">Từ 1.000.000 — 3.000.000 đ
										<input  {{ $price == "1mden3m" ? 'checked' : '' }} onchange="this.form.submit()" value="1mden3m" type="radio" name="price">
										<span class="checkmark"></span>
									</label>
								</li>
								<li>
									<label class="container_check">Trên 3.000.000 đ
										<input  {{ $price == "tren3m" ? 'checked' : '' }} onchange="this.form.submit()" value="tren3m" type="radio" name="price">
										<span class="checkmark"></span>
									</label>
								</li>
							</ul>
							</form>
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
									@php
									if($key == 2) break;
									@endphp
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
							<h3>{{$item->tenSanPham}}</h3>
						</a>
						
						<div class="price_box">
							@if($item->giaKhuyenMai == 0)
							<span class="new_price">{{ number_format($item->gia, 0, '', '.')  }} ₫</span>
							@elseif($item->giaKhuyenMai != 0)
							<span class="new_price">{{ number_format($item->giaKhuyenMai, 0, '', '.')  }} ₫</span>
							<span class="old_price">{{ number_format($item->gia, 0, '', '.')  }} ₫</span>
							@endif
							
						</div>
					
					</div>
					<!-- /grid_item -->
				</div>
				@endforeach
			 </div>	
			
				<div class="pagination__wrapper">
					<ul class="pagination">
						{!!$lstSanPham->appends(request()->input())->links() !!}
					</ul>
				</div>
				
				
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