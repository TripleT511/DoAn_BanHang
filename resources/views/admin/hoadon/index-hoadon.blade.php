@extends('layouts.admin')

@section('title','Quản lý Hoá Đơn')
@section('css')
<style>
  .modal-backdrop.fade {
    display: none;
  } 
  .modal-backdrop.show {
    z-index: 1089;
    display: block;
  }
  .modal-dialog {
    max-width: 80%;
    width: 80%;
  }
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
             <h4 class="fw-bold py-3">Đơn hàng</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                <form action="{{ route('admin.locDonHang') }}" method="POST" >
                  <div class="header-right d-flex align-items-end gap-2">
                      <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                          <span class="d-block">Trạng thái đơn hàng</span>
                          <select id="filter-donhang" name="typeFilter" class="form-select">
                              <option value="" selected>Tuỳ chọn</option>
                              <option value="waiting">Chờ xử lý </option>
                              <option value="processed">Đã xử lý </option>
                              <option value="packing">Đang đóng gói </option>
                              <option value="shipping">Đang giao hàng </option>
                              <option value="done">Đã giao </option>
                              <option value="cancel">Đã huỷ</option>   
                          </select>
                      </div>
                      <div class="header-right-item">
                          <button type="submit" id="locDongHang" class="btn btn-primary">
                              <i class='bx bxs-filter-alt'></i>
                              Lọc
                          </button>
                      </div>
                  </div>
                </form>
              </li>
              <li class="nav-item d-flex align-items-end"  style="margin-left: 15px">
                  <form action="{{ route('admin.timKiemHoaDon') }}" method="POST" class="form-search-custom">
                      <input type="text" class="form-control" name="keyword" id="admin.timKiem" placeholder="Tìm kiếm theo mã đơn hàng, tên, SĐT, Email khách hàng"  style="width: 450px;">
                      <button type="submit" class="btn btn-success"><i class='bx bx-search'></i></button>
                  </form>
              </li>
              <li class="nav-item">
                <a type="button"  href="{{ route('admin.ExportHoaDon') }}" class="nav-link active" >
                    <i class='bx bxs-download'></i>
                    Xuất file
                </a>
              </li>
              <form method="post" action="{{ route('admin.ImportHoaDon')}}" enctype="multipart/form-data">
                @csrf
                @method("POST")   
                <div>
                  <input  type="file"name="file" >
              </div>
                <button type="submit" class="btn btn-primary">Import</button>
              </form>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Ngày tạo</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-right">Tổng thành tiền</th>
                        <th>Hành động</th>               
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstHoaDon as $item)
                      <tr>
                        <td>
                          <a href="#" class="btn-show-detail" data-bs-toggle="modal" data-bs-target="#modalCenter" data-id="{{ $item->id }}">
                            #{{ $item->id }}
                          </a>
                        </td>
                        <td>{{ $item->hoTen }}</td>
                        <td>
                          {{ 
                          date('d-m-Y', strtotime($item->ngayXuatHD))
                          }}
                        </td>
                        
                         <td>
                          @if($item->trangThaiThanhToan == 0) <span class="badge bg-label-dark">Chưa thanh toán</span>
                          @elseif($item->trangThaiThanhToan == 1) <span class="badge bg-label-success">Đã thanh toán</span>
                          @endif
                        </td>
                        <td>
                          @if($item->trangThai == 0) <span class="badge bg-label-primary">Chờ xác nhận</span>
                          @elseif($item->trangThai == 1) <span class="badge bg-label-info">Đã xác nhận</span>
                          @elseif($item->trangThai == 2) <span class="badge bg-label-dark">Chờ giao hàng</span>
                          @elseif($item->trangThai == 3) <span class="badge bg-label-warning">Đang giao hàng</span>
                          @elseif($item->trangThai == 4) <span class="badge bg-label-success">Hoàn thành</span>
                          @elseif($item->trangThai == 5) <span class="badge bg-label-danger">Đã huỷ</span>
                          @endif
                        </td>
                       <td class="text-right">
                          {{ number_format($item->tongThanhTien, 0, '', ',') }} ₫
                        </td>
                        <td>
                          @if($item->trangThai == 0)
                          <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="1">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i> Xác nhận</button>
                          </form>
                          @elseif($item->trangThai == 1) 
                           <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="2">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i>Đóng gói</button>
                          </form>
                          @elseif($item->trangThai == 2) 
                            <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="3">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i> Vận chuyển</button>
                          </form>
                          @endif

                          @if($item->trangThai != 4 && $item->trangThai != 5)
                          <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon'=>$item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="5">
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Huỷ</button>
                          </form>
                          @endif
                        </td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstHoaDon->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
{{-- Model --}}
<div class="modal fade" id="modalCenter" tabindex="-1"  aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">TRIPLET SHOP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="load-data d-flex align-items-center justify-content-center mt-3 mb-3">
          <div role="status" class="spinner-border spinner-border-lg text-info ">
              <span class="visually-hidden">Loading...</span>
          </div>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <a type="button" href="{{ route('admin.hoadonPDF') }}" class="btn btn-primary">Print</a>
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
          Đóng
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal-backdrop fade "></div>
@endsection

@section('js')
  <script>
    $(function() {
      let locDonHangSelect = document.querySelector("#filter-donhang");
      let btnFillter = document.querySelector("#locDongHang");

      btnFillter.addEventListener("click",function(){ 
        let lstType = ['waiting','processed','packing','shipping','done','cancel'];
        let validateValue = lstType.find((value) => value == locDonHangSelect.value);
          if(!!validateValue) {
              $.ajax({
            type: "GET",
            url: "/admin/hoa-don/loc-don-hang",
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

      $(function() {
        let lstBtnOrderDetail = document.querySelectorAll(".btn-show-detail");
        lstBtnOrderDetail.forEach(item => item.addEventListener('click', function(e) {
          e.preventDefault();
          $.ajax({
            type: "get",
            url: "/admin/hoa-don/xem-don-hang",
            dataType: "json",
            data: {
                id: item.dataset.id
            },
            success: function (response) {
              $(".modal-body").html(response.data);
            }
        });
        }) );
        
      })
    });
  </script>
@endsection