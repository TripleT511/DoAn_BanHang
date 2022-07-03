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
	                        <li><a href="{{ route('home') }}">Trang Chủ</a></li>
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
	                    <a href="#0" class="open_filters">
	                        <i class="ti-filter"></i><span>Lọc</span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	    <!-- /toolbox -->
	    <div class="container margin_30">
	        <div class="row">
	            <aside class="col-lg-3">
	                <div class="filter_col">
	                    <div class="inner_bt"><a href="#" class="open_filters"><i class="ti-close"></i></a></div>
	                    <div class="filter_type version_2">
	                        <h4><a href="#filter_1" data-toggle="collapse" class="opened">Danh mục</a></h4>
	                        <div class="collapse show" id="filter_1">
	                            <ul>
	                                <li>
	                                    <label class="container_check">Na, <small>12</small>
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
	                                    <label class="container_check">Bán Thử <small>11</small>
	                                        <input type="checkbox">
	                                        <span class="checkmark"></span>
	                                    </label>
	                                </li>
	                            </ul>
	                        </div>
	                        <!-- /filter_type -->
	                    </div>
	                    <!-- /filter_type -->
	                    <div class="filter_type version_2">
	                        <h4><a href="#filter_2" data-toggle="collapse" class="opened">Màu</a></h4>
	                        <div class="collapse show" id="filter_2">
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
	                        </div>
	                    </div>
	                    <!-- /filter_type -->
	                    <div class="filter_type version_2">
	                        <h4><a href="#filter_3" data-toggle="collapse" class="closed">Nhãn hiệu</a></h4>
	                        <div class="collapse" id="filter_3">
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
	                        </div>
	                    </div>
	                    <!-- /filter_type -->
	                    <div class="filter_type version_2">
	                        <h4><a href="#filter_4" data-toggle="collapse" class="closed">Giá</a></h4>
	                        <div class="collapse" id="filter_4">
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
	                        </div>
	                    </div>
	                    <!-- /filter_type -->
	                    <div class="buttons">
	                        <a href="#0" class="btn_1">Lọc</a> <a href="#0" class="btn_1 gray">Đặt lại</a>
	                    </div>
	                </div>
	                <a href="#0" class="d-none d-lg-block d-xl-block"><img src="img/banner_menu.jpg" alt="" class="img-fluid" width="400" height="550"></a>
	            </aside>
	            <!-- /col -->
	            <div class="col-lg-9">
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon off">-30%</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/1.jpg" alt="">
	                            </a>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Air x Fear</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$48.00</span>
	                            <span class="old_price">$60.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon off">-30%</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/2.jpg" alt="">
	                            </a>
	                            <div data-countdown="2019/05/15" class="countdown"></div>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Okwahn II</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$90.00</span>
	                            <span class="old_price">$170.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon off">-50%</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/3.jpg" alt="">
	                            </a>
	                            <div data-countdown="2019/05/15" class="countdown"></div>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Air Wildwood ACG</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$75.00</span>
	                            <span class="old_price">$155.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon new">New</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/4.jpg" alt="">
	                            </a>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor ACG React Terra</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$110.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon new">New</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/5.jpg" alt="">
	                            </a>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Air Zoom Alpha</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$140.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon new">New</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/6.jpg" alt="">
	                            </a>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Air Alpha</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$130.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="row row_item">
	                    <div class="col-sm-4">
	                        <figure>
	                            <span class="ribbon hot">Hot</span>
	                            <a href="product-detail-1.html">
	                                <img class="img-fluid lazy" src="img/products/product_placeholder_square_medium.jpg" data-src="img/products/shoes/7.jpg" alt="">
	                            </a>
	                        </figure>
	                    </div>
	                    <div class="col-sm-8">
	                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
	                        <a href="product-detail-1.html">
	                            <h3>Armor Air 98</h3>
	                        </a>
	                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident...</p>
	                        <div class="price_box">
	                            <span class="new_price">$115.00</span>
	                        </div>
	                        <ul>
	                            <li><a href="#0" class="btn_1">Add to cart</a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
	                            <li><a href="#0" class="btn_1 gray tooltip-1" data-toggle="tooltip" data-placement="top" title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to compare</span></a></li>
	                        </ul>
	                    </div>
	                </div>
	                <!-- /row_item -->
	                <div class="pagination__wrapper">
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
	                </div>
	            </div>
	            <!-- /col -->
	        </div>
	        <!-- /row -->
	    </div>
	    <!-- /container -->
	</main>
@endsection

@section('js')
<script src="js/sticky_sidebar.min.js"></script>
<script src="js/specific_listing.js"></script>
@endsection