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
		<div class="top_banner version_2">
			<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0)">
				<div class="container">
					<div class="d-flex justify-content-center"><h1>Shoes - Grid listing</h1></div>
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
										<span class="ribbon new">New</span>
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
							<a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}">
								<h3>{{$item->tenSanPham}}</h3>
							</a>
							<div class="price_box">
								@if($item->giaKhuyenMai == 0)
								<span class="new_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
								@elseif($item->giaKhuyenMai != 0)
								<span class="new_price">{{ number_format($item->giaKhuyenMai, 0, '', ',') }} đ</span>
								<span class="old_price">{{ number_format($item->gia, 0, '', ',') }} đ</span>
								@endif
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
					<!-- /row -->
					<div class="pagination__wrapper">
						<ul class="pagination">
							{!!$lstSanPham->withQueryString()->links() !!}
						</ul>
					</div>
			 {{-- <div class="pagination__wrapper">
				<ul class="pagination">
					<li><a href="#0" class="prev" title="previous page">&#10094;</a></li>
					<li>
						<a href="#0" class="active">1</a>
					</li>
					<li>
						<a href="#0">2</a>
					</li>
					<li>
						<a href="#0">3</a>
					</li>
					<li>
						<a href="#0">4</a>
					</li>
					<li><a href="#0" class="next" title="next page">&#10095;</a></li>
				</ul>
			</div> --}}
				
		</div>
		<!-- /container -->
	</main>
@endsection

@section('js')
<script src="js/sticky_sidebar.min.js"></script>
<script src="js/specific_listing.js"></script>
<script>
    $(function() {
            
            //Search
            $('#searchInput').on('keyup', function() {
                var val = $('#searchInput').val();
                if(val != "") {
                    $.ajax({
                    type: "get",
                    url: "/search/timkiem",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                      $("#searchSP").html(response);
                    }
                });
                }
                
            });
		});


</script>

@endsection