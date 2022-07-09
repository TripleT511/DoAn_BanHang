@extends('layouts.admin')

@section('title','Quản lý kho')


@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold ">Nhập kho</h4>
            <ul class="nav nav-pills mb-2">
              <li class="nav-item" >
                  <a class="nav-link active" href="{{ route('phieukho.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
            </ul>
            <ul class="nav nav-pills align-items-end flex-column flex-md-row mb-3">
              <li class="nav-item" style="margin-left: 10px;">
                <form action="{{ route('admin.locPhieuNhap') }}" method="GET" >
                  @if($errors->any()) 
                        @foreach ($errors->all() as $err)
                            <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                        @endforeach
                    @endif    
                  <div class="header-right d-flex align-items-end gap-2">
                      <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                          <span class="d-block">Ngày bắt đầu</span>
                          <input class="form-control" name="ngayBatDau" type="date"  id="startDate">
                      </div>
                      <div class="header-right-item d-flex align-items-start flex-column text-left gap-1">
                          <span class="d-block">Ngày kết thúc</span>
                          <input class="form-control" name="ngayKetThuc" type="date"  id="endDate">
                      </div>
                      <div class="header-right-item">
                          <button type="submit" class="btn btn-primary">
                              <i class='bx bxs-filter-alt'></i>
                              Lọc
                          </button>
                      </div>
                  </div>
                </form>
              </li>
              <li class="nav-item "  style="margin-left: 10px;">
                <form action="{{ route('admin.locPhieuNhap') }}" method="GET" class="form-search-custom">
                      <input type="hidden" name="trangThai"  value="0">
                      <button type="submit" class="btn btn-info"><i class='bx bxs-notepad'></i>Phiếu chờ duyệt</button>
                  </form>
                  
              </li>
              <li class="nav-item d-flex align-items-end"  style="margin-left: 15px">
                  <form action="{{ route('admin.timKiemPhieuNhap') }}" method="GET" class="form-search-custom">
                      <input type="text" class="form-control" name="keyword"  placeholder="Tìm kiếm theo mã đơn nhập hàng, tên nhà cung cấp..."  style="width: 400px;">
                      <button type="submit" class="btn btn-success"><i class='bx bx-search'></i></button>
                  </form>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
               
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Mã</th>
                        <th>Ngày</th>
                        <th>Mã phiếu</th>
                        <th>Người tạo</th>
                        <th>Trạng thái</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstPhieuKho as $item)
                      <tr>
                        <td>
                          <strong>#{{ $item->id }}</strong>
                        </td>
                        <td>
                          {{ $item->ngayTao }}
                        </td>
                        <td>
                          {{ $item->maDonHang }}
                        </td>
                        <td>
                          @if($item->user_id)
                          {{ 
                            $item->user->hoTen
                            }}
                            @endif
                        </td>
                        <td>
                         
                            @if($item->trangThai == 0) 
                              <span class="badge bg-label-info">Đang chờ duyệt</span>
                             @elseif ($item->trangThai == 1)
                              <span class="badge bg-label-primary">Đã thanh toán</span>
                             @else 
                              <span class="badge bg-label-danger">Đã huỷ</span>
                            
                            @endif
                        </td>
                        <td>
                          
                          <a class="btn btn-primary btn-show-phieu-kho" data-bs-toggle="modal" data-bs-target="#modalCenter" data-id="{{ $item->id }}" href="#">
                            <i class='bx bxs-show'></i> 
                          </a>
                          @if($item->trangThai != 1)
                            <form class="d-inline-block" method="post" action="{{ route('phieukho.update', ['phieukho' => $item, 'trangThai' => $item->trangThai ]) }}">
                              @csrf
                              @method("PATCH")
                              <button style="outline: none; border: none" class="btn btn-info" type="submit"><i class='bx bxs-check-circle'></i> </button>
                            </form>
                          @endif
                          <form class="d-inline-block" method="post" action="{{ route('phieukho.destroy', ['phieukho'=>$item]) }}">
                            @csrf
                            @method("DELETE")
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> </button>
                          </form>
                        </td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstPhieuKho->withQueryString()->links() !!}
                </ul>
              </div>
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
                    <button type="button" class="btn btn-primary">Print</button>
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                      Đóng
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-backdrop fade "></div>
@endsection
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
@section('js')
    <script>
      $(function() {
        let lstBtnPhieuKho = document.querySelectorAll(".btn-show-phieu-kho");
        lstBtnPhieuKho.forEach(item => item.addEventListener('click', function(e) {
          e.preventDefault();
          console.log("a");
          $.ajax({
            type: "get",
            url: "/admin/kho/xem-phieu-kho",
            dataType: "json",
            data: {
                id: item.dataset.id
            },
            success: function (response) {
                console.log(response);
                $(".modal-body").html(response);
            }
        });
        }) );
        
      })
    </script>
@endsection