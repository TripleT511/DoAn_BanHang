@extends('layouts.admin')

@section('title','Test')
@section('css')
    <style>
      .img {
        width: 60px;
        position: relative;
      }
      .image-product {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }

      th:nth-of-type(2) {
        width: 60%;
      }
      .loading-item {
    display: none;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1099;
  }

  .loading-item.active {
    display: flex;
    align-items: center;
    justify-content: center;
  }
    .modal-backdrop.fade {
    display: none;
  } 
  .modal-backdrop.show {
    z-index: 1089;
    display: block;
  }
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Chào mừng {{ Auth()->user()->hoTen}} 🎉 </h5>
              <p class="mb-2">
               Chúc bạn một ngày làm việc vui vẻ
              </p>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('ad/assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-12 col-3 mb-4">
      <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <div class="img-custom success">
                  <i class='bx bxs-badge-dollar' ></i>
                </div>
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Doanh thu</span>
            <h3 class="card-title mb-2">{{ number_format($tongDoanhThu, 0, '', '.')  }} ₫</h3>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-3 mb-4">
      <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <div class="img-custom info">
                  <i class='bx bxs-cart-download' ></i>
                </div>
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Đơn hàng</span>
            <h3 class="card-title mb-2">{{  $tongDonHang }}</h3>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-3 mb-4">
      <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <div class="img-custom danger">
                  <i class='bx bxs-t-shirt' ></i>
                </div>
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Sản phẩm</span>
            <h3 class="card-title mb-2">{{ $tongSanPham }}</h3>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-3 mb-4">
      <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <div class="img-custom info">
                  <i class='bx bxs-group' ></i>
                </div>
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Khách hàng</span>
            <h3 class="card-title mb-2">{{ $tongKhachHang }}</h3>
          </div>
        </div>
    </div>
  </div>
  <div class="row align-items-strech d-flex ">
    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card" style="height: 100%;">
        <div class="row row-bordered g-0">
          <div class="col-md-12">
            <div class="p-2">
              <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                  <h5 class="card-header m-0 me-2 pb-3">Sản phẩm gần hết hàng </h5>
                  <div class="mb-3">
                    <select id="topSanPham" name="topSanPham" class="form-select">
                      <option value="">Tuỳ chọn</option>
                      <option value="top5">Top 5</option>
                      <option value="top10">Top 10</option>
                      <option value="top15">Top 15</option>
                  </select>
                  </div>
              </div>
              <div class="table-responsive text-wrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <td>STT</td>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Tồn kho</th>              
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="top-het-hang">
                      @php
                      $count = 0;
                      @endphp
                      @foreach ($lstSanPham as $key => $item)
                      <tr>
                        <td> {{ ++$count }}</td>
                        <td>
                          <div class="img">
                            @foreach ($item->hinhanhs as $key => $item2)
                              @if($key == 1) <?php break; ?> @endif
                                <img src="{{ asset('storage/'.$item2->hinhAnh) }}" class="image-product" alt="{{ $item->tenSanPham }}">
                            @endforeach
                          </div>
                          
                        </td>
                        <td style="width: 20%;"><strong>
                          <a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}" target="_blank">
                          {{ $item->tenSanPham }}
                        </a>  
                        </strong>
                        </td>
                        <td>
                          {{ $item->sizes_sum_so_luong }}
                        </td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!--/ Luot Tim kiem -->
    <div class="col-md-6 col-lg-4 order-2 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Top 10 từ khoá được tìm kiếm </h5>
          <div class="dropdown">
            <button
              class="btn p-0"
              type="button"
              id="transactionID"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
              <a class="dropdown-item" href="javascript:void(0);">Trong ngày</a>
              <a class="dropdown-item" href="javascript:void(0);">Trong Tháng</a>
              <a class="dropdown-item" href="javascript:void(0);">Trong Năm</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0 mb-2">
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="text-left d-block mb-1">Từ Khoá</h6>
                </div>
                <div class="">
                  <h6 class="text-right d-block mb-1">Số lượng</h6>
                </div>
              </div>
          </ul>
          <ul class="p-0 m-0">

          @foreach ($lstLuotTimKiem as $item)
          <li class="d-flex  item-keyword">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="title">
                <h6 class="mb-0">{{ $item->tuKhoa }}</h6>
              </div>
              <div class="count">
                <h6 class="mb-0">{{ $item->soLuong }}</h6>
              </div>
            </div>
          </li>
          @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="loading-item">
    <div role="status" class="spinner-border spinner-border-lg text-primary ">
</div>
</div>
<div class="modal-backdrop fade"></div>
@endsection

@section('js')
<script>
  let lstType = ["top5","top10","top15"];
  let optionTopProducts = document.querySelector("#topSanPham");
  let overlay = document.querySelector(".modal-backdrop");
  let loading = document.querySelector(".loading-item");

 optionTopProducts.addEventListener('change', function(e) {
            let currentValue = e.target.value;
            let lstType = ["top5","top10","top15"];
            let validateValue = lstType.find((value) => value == currentValue);
            if(!!validateValue) {
                overlay.classList.remove("fade");
                overlay.classList.add("show");
                loading.classList.add("active");
                
                $.ajax({
                    type: "GET",
                    url: "/admin/thong-ke-het-hang",
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: currentValue
                    },
                    dataType: "json",
                    success: function (response) {
                        overlay.classList.add("fade");
                        overlay.classList.remove("show");
                        loading.classList.remove("active");
                        
                        if(response.success) {
                             $("#top-het-hang").html(response.data);
                            
                        }
                    }
                });
            }
        }); 
</script>
@endsection
