@extends('layouts.admin')

@section('title','Test')
@section('css')

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
            <h3 class="card-title mb-2">{{ number_format($tongDoanhThu, 0, '', ',') }} ₫</h3>
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
              <h5 class="card-header m-0 me-2 pb-3">Thống kê doanh thu</h5>
              <canvas id="myChart"></canvas>
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
@endsection
@section('js')
  <script>
    $(document).ready(function(){
		$.ajax({
			type: "GET",
			url: "/admin/thong-ke",
			dataType: "json",
			success: function (response) {
        const ctx2 = document.getElementById('myChart').getContext('2d');
  const myChart2 = new Chart(ctx2, {
      type: 'bar',
      data: {
          labels: [
              'Tháng 1',
              'Tháng 2',
              'Tháng 3',
              'Tháng 4',
              'Tháng 5',
              'Tháng 6',
              'Tháng 7',
              'Tháng 8',
              'Tháng 9',
              'Tháng 10',
              'Tháng 11',
              'Tháng 12',
          ],
          datasets: [{
              label: 'Thống kê doanh thu',
              data: response,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 205, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(201, 203, 207, 0.2)'
              ],
              borderColor: [
                  'rgb(255, 99, 132)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(201, 203, 207)'
              ],
              borderWidth: 1,
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          }
      }
  });
			}
		});
	})
  
</script>
@endsection
