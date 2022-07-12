@extends('layouts.user')

@section('title','Chi tiết sản phẩm')

@section('css')

<link href="{{ asset('css/product_page.css') }}" rel="stylesheet">
<link href="{{ asset('css/leave_review.css') }}" rel="stylesheet">
<style>
	
	.product-rating-overview {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		height: 100%;
	}

	.overview-top p {
		font-size: 40px;
		color: #004dda;
		margin-bottom: 10px;
	}
	.overview-bottom i {
		width: 50px;
		height: 50px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		-ms-border-radius: 3px;
		border-radius: 3px;
		font-size: 12px;
		font-size: 0.75rem;
		display: inline-block;
		background-color: #fec348;
		color: #fff;
		line-height: 20px;
		text-align: center;
		margin-right: 2px;
	}

	.overview-bottom i::before {
		font-size: 25px;
		line-height: 50px;
	}

	.review_content .rating i.empty,
	.product-rating-overview i.empty {
    	background-color: #ccc;
	}

	.het-hang {
		padding: 5px 15px;
		background: #fff;
		border: 2px dashed #ccc;
		color: #ccc;
		width: fit-content;
		margin-left: 15px;
	}

	a.btn_1, .btn_1 {
		padding: 10px 17px !important;
	}

	a.btn_2, .btn_2 {
		border: 0 !important;
		padding: 10px 17px !important;
	}

	.btn_2:focus {
		outline: none;
	}
	.modal {
		z-index: 100000 !important;
	}

	.fade {
		z-index: 90000;
	}
	
	.toast {
		z-index: 110000 !important;
	}
</style>
@endsection
@section('content')
<main>
	    <div class="container margin_30">
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
	        
	        <div class="row">
	            <div class="col-md-6">
	                <div class="all">
	                    <div class="slider">
	                        <div class="owl-carousel owl-theme main">
								@foreach ($sanpham->hinhanhs as $key => $item2)
	                            	<div style="background-image: url({{ asset('storage/'.$item2->hinhAnh) }});" class="item-box"></div>
                            	@endforeach
	                        </div>
	                        <div class="left nonl"><i class="ti-angle-left"></i></div>
	                        <div class="right"><i class="ti-angle-right"></i></div>
	                    </div>
	                    <div class="slider-two">
	                        <div class="owl-carousel owl-theme thumbs">
								@foreach ($sanpham->hinhanhs as $key => $item2)
									<div style="background-image: url({{ asset('storage/'.$item2->hinhAnh) }});" class="item {{ $key == 0 ? 'active' : '' }}"></div>
                            	@endforeach
	                        </div>
	                        <div class="left-t nonl-t"></div>
	                        <div class="right-t"></div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6">
	                <div class="breadcrumbs">
	                    <ul>
	                        <li><a href="{{route('home')}}">Trang chủ</a></li>
	                        <li><a href="{{route('san-pham')}}">Sản phẩm</a></li>
	                        <li>{{ $sanpham->tenSanPham }}</li>
	                    </ul>
	                </div>
	                <!-- /page_header -->
	                <div class="prod_info">
	                    <h1>{{ $sanpham->tenSanPham }}</h1>
	                    <span class="rating top-rating">
							@for ($i = 0; $i < $starActive; $i++)
								<i class="icon-star voted"></i>
							@endfor
							@for ($i = 0; $i < $starNonActive; $i++)
								<i class="icon-star"></i>
							@endfor
							
						</span>
						<em class="count-rating rating">( {{ $countRating }} đánh giá )</em>
						@if($sanpham->sku != null)
	                    <p><small>SKU: {{ $sanpham->sku }}</small><br>{!! $sanpham->moTa !!}</p>
						@endif
	                    <div class="prod_options">
	                        <div class="row">
								@if($sanpham->tonKho > 0)
	                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Số lượng</strong></label>
	                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
	                                <div class="numbers-row">
	                                    <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
	                                </div>
	                            </div>
								@else
								<div class="het-hang" >
									Hết hàng
								</div>
								@endif
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-5 col-md-6">
	                            <div class="price_main">
									@if($sanpham->giaKhuyenMai == 0)
									<span class="new_price">{{ number_format($sanpham->gia, 0, '', ',') }} đ
									</span>
									@elseif($sanpham->giaKhuyenMai != 0)
									<span class="new_price">{{ number_format($sanpham->giaKhuyenMai, 0, '', ',') }} đ
									</span>
									<span class="percentage">
									-{{ round((($sanpham->gia - $sanpham->giaKhuyenMai) / $sanpham->gia) * 100) }}%
									</span>
									<span class="old_price">
										{{ number_format($sanpham->gia, 0, '', ',') }} đ
									</span>
									@endif
								</div>
								
	                        </div>
							@if($sanpham->tonKho > 0)
	                        <div class="col-lg-4 col-md-6">
								<a href="javascript:void(0)" id="add-cart" class="btn_1">Thêm vào giỏ hàng</a>
	                        </div>
							@endif
	                    </div>
	                </div>
	                <!-- /prod_info -->
	            </div>
	        </div>
	        <!-- /row -->
	    </div>
	    <!-- /container -->
	    
	    <div class="tabs_product">
	        <div class="container">
	            <ul class="nav nav-tabs" role="tablist">
	                <li class="nav-item">
	                    <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">Nội dung chi tiết</a>
	                </li>
	                <li class="nav-item">
	                    <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">Đánh giá sản phẩm</a>
	                </li>
	            </ul>
	        </div>
	    </div>
	    <!-- /tabs_product -->
	    <div class="tab_content_wrapper">
	        <div class="container">
	            <div class="tab-content" role="tablist">
	                <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
	                    <div class="card-header" role="tab" id="heading-A">
	                        <h5 class="mb-0">
	                            <a class="collapsed" data-toggle="collapse" href="#collapse-A" aria-expanded="false" aria-controls="collapse-A">
	                                NỘI DUNG
	                            </a>
	                        </h5>
	                    </div>
	                    <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
	                        <div class="card-body">
	                            <div class="row justify-content-between">
	                                <div class="col-lg-12">
	                                   {!! $sanpham->noiDung !!}
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <!-- /TAB A -->
	                <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
	                    <div class="card-header" role="tab" id="heading-B">
	                        <h5 class="mb-0">
	                            <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
	                                ĐÁNH GIÁ SẢN PHẨM
	                            </a>
	                        </h5>
	                    </div>
	                    <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
	                        <div class="card-body">
								<div class="row justify-content-center mb-5">
									<div class="col-lg-6">
										<div class="product-rating-overview">
											<div class="overview-top">

												<p><b class="avg-start">{{ $starActive }} / 5</b></p>
											</div>
											<div class="overview-bottom">
											@for ($i = 0; $i < $starActive; $i++)
												<i class="icon-star"></i>
											@endfor
											@for ($i = 0; $i < $starNonActive; $i++)
												<i class="icon-star empty"></i>
											@endfor
										
											</div>
										</div>	
									</div>
									<div class="col-lg-6">
										@auth
										<div class="write_review">
											<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
											<div class="rating_submit">
												<div class="form-group">
												<span class="rating mb-0">
													<input type="radio" class="rating-input" id="5_star" name="rating-input" value="5"><label for="5_star" class="rating-star"></label>
													<input type="radio" class="rating-input" id="4_star" name="rating-input" value="4"><label for="4_star" class="rating-star"></label>
													<input type="radio" class="rating-input" id="3_star" name="rating-input" value="3"><label for="3_star" class="rating-star"></label>
													<input type="radio" class="rating-input" id="2_star" name="rating-input" value="2"><label for="2_star" class="rating-star"></label>
													<input type="radio" class="rating-input" id="1_star" name="rating-input" value="1"><label for="1_star" class="rating-star"></label>
												</span>
												</div>
											</div>
											<input type="hidden"  name="ratingStart"
											id="ratingStart"
											>
											<input type="hidden"  name="userId"
											id="userId" value="{{ Auth()->user() ? Auth()->user()->id : '' }}"
											>
											<input type="hidden" class="rating-input"  name="sanphamId"
											id="sanphamId"
											value="{{ $sanpham->id }}">
											<!-- /rating_submit -->
											<div class="form-group">
												<label>Nội dung đánh giá</label>
												<textarea class="form-control" style="height: 180px;" name="noiDung" 
												id="review-content"
												placeholder="Nhập nội dung tại đây..."></textarea>
											</div>
											<div class="form-group" style="display: none;">
												<label>Gửi ảnh thực tế</label>
												<div class="fileupload"><input type="file" name="fileupload" accept="image/*"></div>
											</div>
											<a href="javascript:void(0)" id="review_btn" class="btn_1">Gửi</a>
										</div>
										@endauth
									</div>
									
								</div>
	                            <div class="row justify-content-between" id="lstReview">
	                               @foreach($lstDanhGia as $item) 
									<div class="col-lg-6">
										<div class="review_content">
											<div class="clearfix add_bottom_10">
												<span class="rating">
												@php
												$starNonActive2 = 5 - $item->xepHang;
												@endphp
												@for($item->xepHang; $item->xepHang > 0; $item->xepHang--)
													<i class="icon-star"></i>
												@endfor
												@for($i = 0; $i < $starNonActive2; $i++)
													<i class="icon-star empty"></i>
												@endfor
												</span>
												<em>{{ date('d-m-Y', strtotime($item->created_at)) }}</em>
											</div>
											<h4>{{  $item->taikhoan->hoTen }}</h4>
											<p class="content-rating-{{ $item->id }}">{{  $item->noiDung }}</p>
											@Auth
											@if(Auth()->user()->id == $item->user_id) 
											<div class="rating-wrapper">
												<a href="#" class="btn_2 btn-delete"  data-toggle="modal" data-target="#exampleModal" data-id="{{ $item->id }}">Xoá</a>
												<a href="#" class="btn_1 btn-edit" data-toggle="modal" data-target="#staticBackdrop"  data-id="{{ $item->id }}">Sửa</a>
											</div>
											@endif
											@endauth
										</div>
									</div>
								   @endforeach
	                            </div>
	                           
	                            <!-- /row -->
	                        </div>
	                        <!-- /card-body -->
	                    </div>
	                </div>
	                <!-- /tab B -->
	            </div>
	            <!-- /tab-content -->
	        </div>
	        <!-- /container -->
	    </div>
	    <!-- /tab_content_wrapper -->

	    <div class="container margin_60_35">
	        <div class="main_title">
	            <h2>Sản Phẩm Liên Quan</h2>
	            <span>Products</span>
	           
	        </div>
	        <div class="owl-carousel owl-theme products_carousel">
				@foreach($lstSanPhamLienQuan as $item)
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
								<img class="owl-lazy" src="{{ asset('storage/'.$item2->hinhAnh) }}" data-src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="">
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
	            
	            <!-- /item -->
	        </div>
	        <!-- /products_carousel -->
	    </div>
	    <!-- /container -->

	    <div class="feat">
			<div class="container">
				<ul>
					<li>
						<div class="box">
							<i class="ti-gift"></i>
							<div class="justify-content-center">
								<h3>Miễn Phí Giao Hàng</h3>
								<p>khi thanh toán hoá đơn trên 1 triệu đồng</p>
							</div>
						</div>
					</li>
					<li>
						<div class="box">
							<i class="ti-wallet"></i>
							<div class="justify-content-center">
								<h3>Thanh toán an toàn</h3>
								<p>100% an toàn khi thanh toán</p>
							</div>
						</div>
					</li>
					<li>
						<div class="box">
							<i class="ti-headphone-alt"></i>
							<div class="justify-content-center">
								<h3> Hổ trợ 24/7 </h3>
								<p>Hỗ trợ trực tuyến hàng đầu</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!--/feat-->
		
	</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border: 0;">
        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xoá không ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer" style="border: 0;">
        <button type="button" class="btn_1 close-modal" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn_2 btn-delete-danhgia" data-id="">Xác nhận</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="border: 0;">
        <h5 class="modal-title" id="staticBackdropLabel">Cập nhật đánh giá</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<ul class="show-error" style="padding: 0;">
			
		</ul>
		<div class="form-group">
			<label for="noiDungDanhGia" class="col-form-label" style="font-size: 16px;">Nội dung đánh giá:</label>
			<textarea name="noiDungDanhGia" id="noiDungDanhGia"  class="form-control" cols="30" rows="5"></textarea>
		</div>
      </div>
      <div class="modal-footer" style="border: 0;">
        <button type="button" class="btn_1 close-modal2" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn_2 btn-update-danhgia" data-id="">Xác nhận</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
 <script  src="{{ asset('js/carousel_with_thumbs.js') }}"></script>
 <script>

	let btnAddCart = document.getElementById('add-cart');
	let closeToast = document.querySelector(".close-toast");
	let btnReview = document.querySelector("#review_btn");
	let lstBtnRatingStart = document.querySelectorAll(".rating-input");
	let toast = document.querySelector(".toast");

	lstBtnRatingStart && lstBtnRatingStart.forEach(item => item.addEventListener('click', function() {
		$("#ratingStart").val(item
			.value);
	}));

	// Render Cart khi vừa vô trang 
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

		function abc() {
			let lstBtnDelete = document.querySelectorAll(".btn-trash");
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

	//Thêm giỏ hàng
  btnAddCart &&	btnAddCart.addEventListener("click", function(){
		let soLuong = $("#quantity_1").val();
		if(isNaN(soLuong) || soLuong <= 0 || soLuong.length == 0) {
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
				url: "/add-to-cart",
				dataType: "json",
				data: {
					_token: $("#token").val(),
					sanphamId: $("#sanphamId").val(),
					soLuong: soLuong,
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
					} else {
						toast.querySelector(".toast-body").innerHTML = response.message;
						toast.classList.remove("toast-danger");
						toast.classList.add("toast-success", "show");
						setTimeout(() => {
							toast.classList.remove("show");
							}, 2000);
						$("#lstReview").html(response.output);
						$("#lstItemCart").html(response.newCart);
						document.querySelector(".total_drop div span").innerHTML = `${response.total} ₫`;
						document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
					}
				}
			});
	});

	// Đánh giá sản phẩm
	btnReview && btnReview.addEventListener("click", function(){
		if($("#userId").val() == "") return;
		$.ajax({
			type: "POST",
			url: "/review",
			dataType: "json",
			data: {
				_token: $("#token").val(),
				sanphamId: $("#sanphamId").val(),
				user_id: $("#userId").val(),
				noiDung: $("#review-content").val(),
				xepHang: $("#ratingStart").val() != '' ? $("#ratingStart").val() : null,
			},
			error: function(response) {
				if(response.status == 302) {
					toast.querySelector(".toast-body").innerHTML = "Vui lòng đăng nhập để thực hiện chức năng này";
					toast.classList.remove("toast-success");
						toast.classList.add("toast-danger", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
				}
			},
			success: function (response) {
			
				if(response.error) {
					toast.querySelector(".toast-body").innerHTML = response.error;
					toast.classList.remove("toast-success");
						toast.classList.add("toast-danger", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
				} else {
					toast.querySelector(".toast-body").innerHTML = response.success;
					toast.classList.remove("toast-danger");
					toast.classList.add("toast-success", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
					$("#lstReview").html(response.output);
					$(".avg-start").html(response.avg + " / 5");
					$(".count-rating").html(response.count);
					$(".overview-bottom").html(response.outputMain2);
					$(".top-rating").html(response.outputMain1);

					lstBtnDeleteRating = document.querySelectorAll(".btn-delete");
					lstBtnUpdateRating = document.querySelectorAll(".btn-edit");
					lstBtnDeleteRating.forEach((item) => item.addEventListener("click", function () {
						btnDeleteRatingAjax.setAttribute("data-id", item.dataset.id);
					}));

					lstBtnUpdateRating.forEach((item) => item.addEventListener("click", function () {
						btnUpdateRatingAjax.setAttribute("data-id", item.dataset.id);
					}));
				}
			}
		});
	});

	// Xoá đánh giá
	let lstBtnDeleteRating = document.querySelectorAll(".btn-delete");
	let lstBtnUpdateRating = document.querySelectorAll(".btn-edit");

	let btnDeleteRatingAjax = document.querySelector(".btn-delete-danhgia");
	let btnUpdateRatingAjax = document.querySelector(".btn-update-danhgia");


	let btnCloseModel = document.querySelector(".close-modal");
	let btnCloseModel2 = document.querySelector(".close-modal2");

	lstBtnDeleteRating.forEach((item) => item.addEventListener("click", function () {
		btnDeleteRatingAjax.setAttribute("data-id", item.dataset.id);
	}));

	lstBtnUpdateRating.forEach((item) => item.addEventListener("click", function () {
		btnUpdateRatingAjax.setAttribute("data-id", item.dataset.id);
		let contentRating = document.querySelector(`.content-rating-${item.dataset.id}`);
		$("#noiDungDanhGia").val(contentRating.innerText);
	}));

	// *** Xoá Đánh Giá *** //
	btnDeleteRatingAjax.addEventListener("click", function() {
		btnCloseModel.click();
		if(this.dataset.id != "" || this.dataset.id != undefined) {
			$.ajax({
			type: "DELETE",
			url: "/xoa-danh-gia",
			dataType: "json",
			data: {
				_token: $("#token").val(),
				id: this.dataset.id,
				sanphamId: '{{ $sanpham->id }}'
			},
			success: function (response) {
				if(response.error) {
					toast.querySelector(".toast-body").innerHTML = response.error;
					toast.classList.remove("toast-success");
						toast.classList.add("toast-danger", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
				} 
				if(response.success) {
					toast.querySelector(".toast-body").innerHTML = response.success;
					toast.classList.remove("toast-danger");
					toast.classList.add("toast-success", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
					$("#lstReview").html(response.output);
					$(".avg-start").html(response.avg + " / 5");
					$(".count-rating").html(response.count);
					$(".overview-bottom").html(response.outputMain2);
					$(".top-rating").html(response.outputMain1);
					
					lstBtnDeleteRating = document.querySelectorAll(".btn-delete");
					lstBtnUpdateRating = document.querySelectorAll(".btn-edit");
					lstBtnDeleteRating.forEach((item) => item.addEventListener("click", function () {
						btnDeleteRatingAjax.setAttribute("data-id", item.dataset.id);
					}));

					lstBtnUpdateRating.forEach((item) => item.addEventListener("click", function () {
						btnUpdateRatingAjax.setAttribute("data-id", item.dataset.id);
						let contentRating = document.querySelector(`.content-rating-${item.dataset.id}`);
						$("#noiDungDanhGia").val(contentRating.innerText);
					}));
				}
			}
		});
		}
		
	});

	// *** Xoá Đánh Giá *** //

	// *** Cập Nhật Đánh Giá *** //
	btnUpdateRatingAjax.addEventListener("click", function() {
		if(this.dataset.id != "" || this.dataset.id != undefined) {
			$.ajax({
			type: "PATCH",
			url: "/cap-nhat-danh-gia",
			dataType: "json",
			data: {
				_token: $("#token").val(),
				id: this.dataset.id,
				sanphamId: '{{ $sanpham->id }}',
				noiDung: $("#noiDungDanhGia").val(),
			},
			success: function (response) {
				if(response.error) {
					document.querySelector(".show-error").innerHTML = response.error;
				} 
				if(response.success) {
					btnCloseModel2.click();
					document.querySelector(".show-error").innerHTML = "";
					toast.querySelector(".toast-body").innerHTML = response.success;
					toast.classList.remove("toast-danger");
					toast.classList.add("toast-success", "show");
					setTimeout(() => {
						toast.classList.remove("show");
						}, 2000);
					$("#lstReview").html(response.output);
					$(".avg-start").html(response.avg + " / 5");
					$(".count-rating").html(response.count);
					$(".overview-bottom").html(response.outputMain2);
					$(".top-rating").html(response.outputMain1);
					
					lstBtnDeleteRating = document.querySelectorAll(".btn-delete");
					lstBtnUpdateRating = document.querySelectorAll(".btn-edit");
					lstBtnDeleteRating.forEach((item) => item.addEventListener("click", function () {
						btnDeleteRatingAjax.setAttribute("data-id", item.dataset.id);
					}));

					lstBtnUpdateRating.forEach((item) => item.addEventListener("click", function () {
						btnUpdateRatingAjax.setAttribute("data-id", item.dataset.id);
						let contentRating = document.querySelector(`.content-rating-${item.dataset.id}`);
						$("#noiDungDanhGia").val(contentRating.innerText);
					}));
				}
			}
		});
		}
		
	});

	// *** Cập Nhật Đánh Giá *** //

	closeToast.addEventListener('click', function() {
		toast.classList.remove("show");
	})
 </script>
@endsection