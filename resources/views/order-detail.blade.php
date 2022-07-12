@extends('layouts.user')

@section('title','Đơn hàng của tôi')

@section('css')

<link href="{{ asset('css/cart.css') }}" rel="stylesheet">
<style>
	.table.cart-list th:nth-child(1) {
		width: 15%;
	}
	.table.cart-list th:nth-child(2) {
		width: 40%;
	}
	.table.cart-list th:nth-child(3) {
    	width: 20%;
	}
	.table.cart-list th:nth-child(4) {
		width: 10%;
	}
	.table.cart-list th:nth-child(5) {
		width: 15%;
	}
	.badge {
    text-transform: uppercase;
    line-height: 0.75;
}

.badge {
    display: inline-block;
    padding: 0.52em 0.593em;
    font-size: 0.8125em;
    font-weight: 500;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.bg-label-danger {
    background-color: #ffe0db !important;
    color: #ff3e1d !important;
}

.bg-label-warning {
    background-color: #fff2d6 !important;
    color: #ffab00 !important;
}

.bg-label-success {
    background-color: #e8fadf !important;
    color: #71dd37 !important;
}

.bg-label-info {
    background-color: #d7f5fc !important;
    color: #03c3ec !important;
}

.bg-label-primary {
    background-color: #e7e7ff !important;
    color: #696cff !important;
}

.bg-label-dark {
    background-color: #dcdfe1 !important;
    color: #233446 !important;
}

.lst-product {
	list-style: initial;
	padding: 0;
}

.lst-product li a {
	display: block;
	padding: 5px 0;
	color: #000;
}

.lst-product li a h5 {
	font-size: 16px;
}


.btn {
    cursor: pointer;
}
.btn {
    display: inline-block;
    font-weight: 400;
    line-height: 1.53;
    color: #697a8d;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: 0.4375rem 1.25rem;
    font-size: 0.9375rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease-in-out;
}

.btn-success {
    color: #fff;
    background-color: #71dd37;
    border-color: #71dd37;
    box-shadow: 0 0.125rem 0.25rem 0 rgb(113 221 55 / 40%);
}

.btn-primary {
    color: #fff;
    background-color: #696cff;
    border-color: #696cff;
    box-shadow: 0 0.125rem 0.25rem 0 rgb(105 108 255 / 40%);
}
.btn-danger {
    color: #fff;
    background-color: #ff3e1d;
    border-color: #ff3e1d;
    box-shadow: 0 0.125rem 0.25rem 0 rgb(255 62 29 / 40%);
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
		<div class="container margin_30">
			
			<div class="page_header">
				<div class="breadcrumbs">
					<ul>
						<li><a href="#">Trang chủ</a></li>
						<li>Đơn hàng của tôi</li>
						<li>Chi tiết đơn hàng</li>
					</ul>
				</div>
				<h1>Chi tiết đơn hàng</h1>
			</div>
			<table class="table table-striped cart-list">
				<thead>
					<tr>
						<th class="text-left">
							STT
						</th>
						<th class="text-left">
							Tên sản phẩm
						</th>
                        <th class="text-right">
                            Số lượng
                        </th>
						<th class="text-right">
							Giá
						</th>
						<th class="text-right">
							Thành tiền
						</th>
						
					</tr>
				</thead>
				<tbody id="lstOrder">
					@foreach($hoadon->chiTietHoaDons as $value => $item) 
                        @php
                         $tongTien = (int)$item->soLuong * (float)$item->donGia;
                        @endphp
					<tr>
                        <td class="text-left">
                            {{ $value + 1 }}
                        </td>
                        <td class="text-left">
                            {{ $item->sanpham->tenSanPham }}
                        </td>
                        
                        <td class="text-right">
                            {{ $item->soLuong }}
                        </td>
                        <td class="text-right">         
                            {{ number_format($item->donGia, 0, ',', ',') }} đ
                        </td>
                        <td class="text-right">
                            {{ number_format($tongTien, 0, ',', ',') }} đ
                        </td>
					</tr>
					@endforeach
				</tbody>
			</table>
    <div class="box_cart">
		<div class="container">
			<div class="row justify-content-end">
				<div class="col-xl-4 col-lg-4 col-md-6">
                    <ul class="info-cart">
                        <li>
                            <span>Tạm tính:</span> 
                            <p class="cart-price">{{ number_format($hoadon->tongTien, 0, '', ',') }} ₫</p>
                        </li>
                        <li>
                            <span>Giảm giá:</span> <p class="discount" style="margin: 0;">{{ number_format($hoadon->giamGia, 0, '', ',') }} ₫</p> 
                        </li>
                        <li>
                            <span>Tổng cộng:</span> 
                            <b  class="cart-total">{{ number_format($hoadon->tongThanhTien, 0, '', ',') }} ₫</b>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
			
		</div>
		<!-- /container -->
		
		
		
</main>

@endsection
@section('js')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" ></script>

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
	})
		let locDonHangSelect = document.querySelector("#filter-donhang");
		let btnFillter = document.querySelector("#locDongHang");

		btnFillter.addEventListener("click",function(){ 
			let lstType = ['waiting','processed','packing','shipping','done','cancel'];
            let validateValue = lstType.find((value) => value == locDonHangSelect.value);
			
            if(!!validateValue) {
				$.ajax({
			type: "GET",
			url: "/loc-don-hang",
			data: {
				type: locDonHangSelect.value
			},
			dataType: "json",
			success: function (response) {
				console.log(response);
				$("#lstOrder").html(response.data);
			}
		});
			}

		});
		
		
	</script>
@endsection