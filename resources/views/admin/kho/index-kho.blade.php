@extends('layouts.admin')

@section('title','Quản lý kho')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng phiếu kho</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('phieukho.create') }}">
                    <i class='bx bx-plus'></i> Thêm phiếu kho</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách phiếu</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Phiếu</th>
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
                          <strong>{{ ($item->loaiPhieu == 0 ? "Phiếu Nhập" : "Phiếu Xuất") }}</strong>
                        </td>
                        <td>
                          {{ $item->ngayTao }}
                        </td>
                        <td>
                          {{ $item->maDonHang }}
                        </td>
                        <td>
                          {{ $item->user->hoTen }}
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
                            <i class='bx bxs-show'></i> Xem
                          </a>
                          <form class="d-inline-block" method="post" action="{{ route('phieukho.update', ['phieukho' => $item, 'trangThai' => $item->trangThai ]) }}">
                            @csrf
                            @method("PATCH")
                            <button style="outline: none; border: none" class="btn btn-info" type="submit"><i class='bx bxs-check-circle'></i> Duyệt</button>
                          </form>
                          <form class="d-inline-block" method="post" action="{{ route('phieukho.destroy', ['phieukho'=>$item]) }}">
                            @csrf
                            @method("DELETE")
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Xoá</button>
                          </form>
                        </td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
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
                      Close
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