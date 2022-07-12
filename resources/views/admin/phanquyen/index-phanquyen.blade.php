@extends('layouts.admin')

@section('title','Quản lý phân quyền')

@section('content')
<div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-50 start-50 translate-middle " role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
  <div class="toast-header">
      <i class="bx bx-bell me-2"></i>
      <div class="me-auto fw-semibold">Thông báo</div>
      <small>1 second ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">Lỗi</div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3">Phân quyền</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('phanquyen.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
              <li class="nav-item "  style="margin-left: 10px;">
                <form action="{{ route('searchPhanQuyen') }}" method="GET" class="form-search-custom">
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
                        <th>Tên vị trí</th>
                        <th>Mã vị trí</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="lstPhanQuyen">
                      @foreach ($lstPhanQuyen as $item)
                        <tr>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->tenViTri }}</strong></td>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{ $item->viTri }}</td>
                          <td>
                            <a class="btn btn-success btn-change-tenvitri" data-bs-toggle="modal" data-bs-target="#modalCenter"  data-id="{{ $item->id }}" href="#">
                              <i class='bx bx-edit-alt me-1'></i>
                            </a>
                            <button type="button"  class="btn btn-danger btn-delete-phanquyen" data-route="{{ route('phanquyen.destroy', ['phanquyen'=>$item]) }}" data-bs-toggle="modal" data-bs-target="#basicModal">
                          <i class="bx bx-trash me-1"></i>
                          </button>
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
                  {!!$lstPhanQuyen->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
            <div class="modal fade" id="modalCenter" tabindex="-1"  aria-modal="true" role="dialog">
              <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Đổi tên vị trí</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  
                  <div class="modal-body">
                      <form method="post" action="javascript:void(0)" id="form_changetenvitri" enctype="multipart/form-data">
                          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                          <div class="mb-3">
                            <label class="form-label" for="tenViTri">Tên vị trí</label>
                            <input type="text" name="tenViTri" class="form-control" id="tenViTri"  placeholder="Nhập tên vị trí" />
                        </div>
                                  
                          <input type="hidden" id="phanquyen_id" >
                          <button type="submit" class="btn btn-primary btn-change">Đổi</button>
                      </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="closeModel" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Đóng
                    </button>
                  </div>
              </div>
              </div>
          </div>
<div class="modal-backdrop fade "></div>
{{-- Model Delete --}}
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
  $(function() {
    let lstRemoveProduct = document.querySelectorAll(".table-product tr");
    let lstSP = document.querySelectorAll(".product-search-item");
    let lstBtnDelete = document.querySelectorAll(".btn-xoa");
    let lstBtnUpdate = document.querySelectorAll(".btn-update");
    let lstBtnChangeTenViTri = document.querySelectorAll(".btn-change-tenvitri");
    let btnChange = document.querySelector(".btn-change");

    //Đổi mật khẩu
    lstBtnChangeTenViTri.forEach(item => item.addEventListener('click', function(e) {
      e.preventDefault();
      $("#phanquyen_id").val(item.dataset.id);
      btnChange.addEventListener('click', function() 
      {
        console.log("a");
        $.ajax({
          type: "POST",
          url: "/admin/doi-ten-vi-tri",
          data: {
              _token: $("#token").val(),
              tenViTri: $("#tenViTri").val(),
              phanquyen_id: $("#phanquyen_id").val(),
          },
          dataType: "json",
          success: function (response) {
            if(response.error) {
              document.querySelector(".bs-toast").classList.add("bg-danger");
              document.querySelector(".bs-toast").classList.remove("bg-success");
              document.querySelector(".toast-body").innerHTML = response.error;
              document.querySelector(".bs-toast").classList.add("show");
              setTimeout(() => {
                  document.querySelector(".bs-toast").classList.remove("show");
              }, 2000);
              return;
            }

            $("#lstPhanQuyen").html(response.data);
            let btnShowModel = document.querySelector("#closeModel");
            btnShowModel.click();

            document.querySelector(".bs-toast").classList.add("bg-success");
            document.querySelector(".bs-toast").classList.remove("bg-danger");
            document.querySelector(".toast-body").innerHTML = response.success;
            document.querySelector(".bs-toast").classList.add("show");
            setTimeout(() => {
                document.querySelector(".bs-toast").classList.remove("show");
            }, 2000);

            
          }
        });

      });
      
    }));
  });

  let lstBtnDeleteRoute = document.querySelectorAll(".btn-delete-phanquyen");
      lstBtnDeleteRoute.forEach((item) => item.addEventListener("click", function() {
        let linkRoute = item.dataset.route;
        let formDel = document.querySelector("#form-delete");
        formDel.action  = linkRoute;
      }));
          
</script>

@endsection