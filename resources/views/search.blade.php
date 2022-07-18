@extends('layouts.user')

@section('title','Tìm kiếm')

@section('css')

<link href="{{ asset('css/listing.css') }}" rel="stylesheet">
<style>
	.page-item.active span {
		color: #004dda;
	}
</style>
@endsection
@section('content')
<main>
		<!-- /top_banner -->
		
			<div id="stick_here"></div>		
			<div class="toolbox elemento_stick">
				<div class="container">
				<ul class="clearfix">
					<li>
						<div class="sort_select">
							<form action="{{ route('searchSanPham') }}" method="GET">
								<input type="hidden" name="page" value="{{ $lstSanPham->currentPage() }}">
								<input type="hidden" name="keyword" value="{{ $keyword ? $keyword : '' }}">
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
				</ul>
				<div class="collapse" id="filters"><div class="row small-gutters filters_listing_1">
				
			</div></div>
				</div>
			</div>
			<!-- /toolbofgddasx -->
			
			<div class="container margin_30">
				<div class="search-wrapper mb-5">
					<h3 class="title">
						Từ khoá tìm kiếm: {{ $keyword }}
					</h3>
					<span> <i>( {{$soluong}} kết quả tìm kiếm )</i></span>
				</div>
				<div class="row small-gutters" id="searchSP">
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
									@foreach($item->hinhanhs as $key => $item2) 
									@if($key == 1) <?php break; ?> @endif
										<img class="img-fluid lazy loaded" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="{{ $item->tenSanPham }}" >
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
					<!-- /row -->
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
<script src="js/sticky_sidebar.min.js"></script>
<script src="js/specific_listing.js"></script>
<script>
    $(function() {
            
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
	});
		
</script>

@endsection