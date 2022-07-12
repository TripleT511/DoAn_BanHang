@extends('layouts.admin')

@section('title','Báo cáo bán hàng')
@section('css')
<style>
  .img-custom {
    width: 45px;
    height: 45px;
    padding: 5px;
    border-radius: 5px;
    background: #d7d7d7;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .img-custom.success {
    background: #eefbe7;
    color: rgb(113, 221, 55);
  }

  .img-custom.info {
    background: #ededff;
    color: rgb(3, 195, 236);
  }

  .img-custom.danger {
    background: #ffe7e3;
    color: rgb(255, 62, 29);
  }

  .img-custom.warning {
    background: #fff5e0;
    color: rgb(255, 171, 0);
  }

  .img-custom i {
    display: block;
    margin: auto;
    font-size: 22px;
  }

  .item-keyword {
    padding: 10px 0;
  }

  .card-header-custom {
    margin-top: 15px;
    padding: 0 24px;
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
    <h4 class="fw-bold py-3">Thống kê</h4>
    <div class="row ">
        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card" style="height: 100%;">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="thongKeDonHang"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="thongKeDoanhThu"></canvas>
                    </div>
                </div>
                <div class="row row-bordered g-0">
                    <div class="col-md-12">
                        <div class="p-2">
                            <h5 class="card-header m-0 me-2 pb-1">Doanh thu cửa hàng 7 ngày qua</h5>
                            <div class="card-header-custom d-flex align-items-end justify-content-between mb-3">
                                <div class="header-left">
                                    <ul class="nav nav-pills" >
                                        <li class="nav-item">
                                            <a type="button"  href="{{ route('admin.ExportBaoCao') }}" class="nav-link active" >
                                                <i class='bx bxs-download'></i>
                                                Xuất file
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="header-right d-flex align-items-end gap-2">
                                    <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                                        <span class="d-block">Khoảng thời gian</span>
                                        <select id="khoangThoiGian" name="khoangThoiGian" class="form-select">
                                            <option value="">Tuỳ chọn</option>
                                            <option value="today">Hôm nay</option>
                                            <option value="yesterday">Hôm qua</option>
                                            <option value="last7days">7 ngày trước</option>
                                            <option value="last30days">30 ngày trước</option>
                                            <option value="last90days">90 ngày trước</option>
                                            <option value="lastmonth">Tháng trước</option>
                                            <option value="quarter1">Quý 1</option>  
                                            <option value="quarter2">Quý 2</option>     
                                            <option value="quarter3">Quý 3</option>     
                                            <option value="quarter4">Quý 4</option>     
                                        </select>
                                    </div>
                                    <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                                        <span class="d-block">Ngày bắt đầu</span>
                                        <input class="form-control" type="date" value="2021-06-18" id="startDate">
                                    </div>
                                    <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                                        <span class="d-block">Ngày kết thúc</span>
                                        <input class="form-control" type="date" value="2021-06-18" id="endDate">
                                    </div>
                                    <div class="header-right-item">
                                        <button type="submit" class="btn btn-primary">
                                            <i class='bx bxs-filter-alt'></i>
                                            Lọc
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-left">Mã đơn hàng</th>
                                    <th class="text-left">Số lượng đặt hàng</th>
                                    <th class="text-right">Doanh thu</th>
                                    <th class="text-right">Giảm giá</th>
                                    <th class="text-right">Tổng Doanh thu</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" id="thongKeDoanhThuTheoThoiGian">
                                @php
                                    $tongSLDonHang = 0;
                                    $tongDoanhThuDonHang = 0;
                                    $tongGiamGiaDonHang = 0;
                                    $tongDoanhThu = 0;
                                @endphp
                                @foreach($doanhThuAfter7Days as $item)
                                    @php
                                        $giamGia = 0;
                                        $doanhThu = $item->tongTien;
                                        if($item->ma_giam_gia_id != null) {
                                            $doanhThu = 0;
                                            foreach($item->chiTietHoaDons as $item2) {
                                                $doanhThu += $item2->soLuong * $item2->donGia;
                                            }

                                            $giamGia = $doanhThu - $item->tongTien;
                                        }

                                        $tongSLDonHang += $item->chi_tiet_hoa_dons_sum_so_luong;
                                        $tongDoanhThuDonHang += $doanhThu;
                                        $tongGiamGiaDonHang += $giamGia;
                                        $tongDoanhThu += $item->tongTien;
                                    @endphp
                                <tr>
                                    <td class="text-left">
                                        #{{ $item->id }}
                                    </td>
                                    <td class="text-left">
                                        {{ $item->chi_tiet_hoa_dons_sum_so_luong }}
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($doanhThu, 0, '', ',') }} ₫
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($giamGia, 0, '', ',') }} ₫
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($item->tongTien, 0, '', ',') }} ₫
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="text-left"><strong>Tổng:</strong></td>
                                    <td class="text-left"><strong>{{ $tongSLDonHang }}</strong></td>
                                    <td class="text-right"><strong>{{ number_format($tongDoanhThuDonHang, 0, '', ',') }} ₫</strong></td>
                                    <td class="text-right"><strong>{{ number_format($tongGiamGiaDonHang, 0, '', ',') }} ₫</strong></td>
                                    <td class="text-right"><strong>{{ number_format($tongDoanhThu, 0, '', ',') }} ₫</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="card my-2">
                <div class="table-responsive text-nowrap">
                   <h5 class="card-header m-0 me-2 pb-1">Sản phẩm bán chạy</h5>
                   <div class="card-header-custom d-flex align-items-end justify-content-between mb-3">
                        <div class="header-left">
                            <ul class="nav nav-pills" >
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" >
                                        <i class='bx bxs-download'></i>
                                        Xuất file
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="header-right d-flex align-items-end gap-2">
                            <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                                <span class="d-block">Top sản phẩm bán chạy</span>
                                <select id="topSanPham" name="topSanPham" class="form-select">
                                    <option value="">Tuỳ chọn</option>
                                    <option value="top5">Top 5</option>
                                    <option value="top10">Top 10</option>
                                    <option value="top15">Top 15</option>
                                </select>
                            </div>
                        </div>
                    </div>
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Sản phẩm</th>
                        <th class="text-right">Tổng số lượng</th>
                        <th class="text-right">Tổng thành tiền</th>
                        <th class="text-right">Tổng đơn hàng</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="topSanPhamBanChay">
                    @php
                        $tongSoLuongSanPham = 0;
                        $tongThanhTien = 0;
                        $tongDonHang = 0;
                    @endphp
                    @foreach($top5SanPhamBanChay as $key => $item)
                        @php
                            $thanhTien = 0;
                            $soLuong = ($item->chitiethoadons_sum_so_luong) ? $item->chitiethoadons_sum_so_luong : 0;
                            $donHang = ($item->chitiethoadons_count) ? $item->chitiethoadons_count : 0;
                            $thanhTien = $soLuong * $item->gia;
                            $tongSoLuongSanPham += $soLuong;
                            $tongThanhTien += $thanhTien;
                            $tongDonHang += $donHang;
                        @endphp
                      <tr>
                        <td class="text-left">
                            {{ ++$key }}
                        </td class="text-left">
                        <td>
                            <a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}" class="text-primary" target="_blank" title="{{ $item->tenSanPham }}">
                                {{ $item->tenSanPham }}
                            </a>
                        </td>
                        <td class="text-right">
                            {{ $soLuong }}
                        </td>
                        <td class="text-right">
                           {{ number_format($thanhTien, 0, '', ',') }} ₫
                        </td>
                        <td class="text-right">
                            {{ $donHang }}
                        </td>
                      </tr>
                    @endforeach
                    <tr>
                        <td><strong>Tổng:</strong></td>
                        <td></td>
                        <td class="text-right"><strong>{{ $tongSoLuongSanPham }}</strong></td>
                        <td class="text-right"><strong>{{ number_format($tongThanhTien, 0, '', ',') }} ₫</strong></td>
                        <td class="text-right"><strong>{{ $tongDonHang }}</strong></td>
                    </tr>
                    </tbody>
                  </table>
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
    $(document).ready(function(){
        var ctx2 = document.getElementById('myChart').getContext('2d');
        var myChart2;
		$.ajax({
			type: "GET",
			url: "/admin/thong-ke-doanh-thu-after-7-days",
			dataType: "json",
			success: function (response) {
                
                myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: response.labels,
                        datasets: [{
                            label: 'Doanh thu bán hàng',
                            data: response.data,
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

        let optionTime = document.querySelector("#khoangThoiGian");
        let optionTopProducts = document.querySelector("#topSanPham");
        let overlay = document.querySelector(".modal-backdrop");
        let loading = document.querySelector(".loading-item");

        // *** Top Sản Phẩm Bán Chạy *** //
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
                    url: "/admin/thong-ke-san-pham-ban-chay",
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
                             $("#topSanPhamBanChay").html(response.data);
                            
                        }
                    }
                });
            }
        }); 
        // *** Top Sản Phẩm Bán Chạy *** //



        optionTime.addEventListener('change', function(e) {
            let currentValue = e.target.value;
            let lstType = ["today","yesterday","last7days","last30days","last90days","lastmonth","quarter1","quarter2","quarter3","quarter4"];
            let validateValue = lstType.find((value) => value == currentValue);
            if(!!validateValue) {
                overlay.classList.remove("fade");
                overlay.classList.add("show");
                loading.classList.add("active");
                
                $.ajax({
                    type: "GET",
                    url: "/admin/thong-ke-khoang-thoi-gian",
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
                            $("#thongKeDoanhThuTheoThoiGian").html(response.data);
                            if(response.type == 'today' || response.type == 'yesterday') {
                                $("#myChart").hide();
                            } else {
                                $("#myChart").show();
                                myChart2.data.labels = response.labels;
                                myChart2.data.datasets[0].data = response.chartData;
                                
                                myChart2.update();
                            }
                           
                        }
                    }
                });

                
            }
        }); 
	});
  
</script>
@endsection
