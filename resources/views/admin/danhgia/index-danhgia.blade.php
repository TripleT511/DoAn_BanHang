@extends('layouts.admin')

@section('title','Quản lý Đánh Giá')
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
              <h4 class="fw-bold py-3">Đánh giá</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item "  style="margin-left: 10px;">
                <form action="{{ route('searchDanhGia') }}" method="GET" class="form-search-custom">
                    <input type="text" class="form-control" name="keyword" id="searchDanhMuc" placeholder="Từ khoá ..."  >
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
                        <th>Tên sản phẩm</th>                    
                        <th>Họ tên</th>
                        <th>Nội dung</th>
                        <th>Rating</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="lstBinhLuan">
                    @foreach ($lstDanhGia as $item)
                      <tr>
                      </td>
                        <td>
                          <a href="{{ route('chitietsanpham', ['slug' => $item->sanpham->slug]) }}" target="_blank">
                            <strong>{{ $item->sanpham->tenSanPham }}</strong>
                          </a>
                          
                      </td>
                      </td>
                        <td>{{ $item->taikhoan->hoTen }}</>
                      </td>
                      </td>
                        <td>{{ $item->noiDung }}</>
                      </td>
                      </td>
                        <td>{{ $item->xepHang }}</>
                      </td>
                      <td>
                        <button type="button"  class="btn btn-danger btn-delete-danhgia" data-route="{{ route('danhgia.destroy', ['danhgium' => $item]) }}" data-bs-toggle="modal" data-bs-target="#basicModal">
                          <i class="bx bx-trash me-1"></i>
                          </button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstDanhGia->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
{{-- Model Delete --}}
<div class="modal-backdrop fade "></div>
<div class="modal fade" id="basicModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 30%; width: 30%;">
    <div class="modal-content">
      <div class="modal-header justify-content-center py-4">
        <h5 class="modal-title text-center w-100" id="exampleModalLabel1">Bạn có chắc chắn muốn xoá không ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" >
         Đóng
        </button>
         <form class="d-inline-block" method="post" id="form-delete" action="">
          @csrf
          @method("DELETE")
          <button style="outline: none; border: none" class="btn btn-danger" type="submit"> Xác nhận </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
    
  let lstBtnDeleteRoute = document.querySelectorAll(".btn-delete-danhgia");
  lstBtnDeleteRoute.forEach((item) => item.addEventListener("click", function() {
    let linkRoute = item.dataset.route;
    let formDel = document.querySelector("#form-delete");
    formDel.action  = linkRoute;
  }));

</script>

@endsection