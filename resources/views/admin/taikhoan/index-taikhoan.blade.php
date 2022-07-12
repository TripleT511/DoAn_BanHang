@extends('layouts.admin')

@section('title','Quản lý tài khoản')
@section('css')
    <style>
      .img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
      }
      .img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      .nav {
        gap: 10px;
        flex-wrap: wrap;
      }
    </style>
@endsection
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
            <h4 class="fw-bold py-3">Tài khoản</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('user.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.index', ['block' => true]) }}" class="btn btn-danger">
                  <i class='bx bx-trash-alt'></i>
                  Tài khoản bị khoá
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.index', ['phan_quyen_id' => '2']) }}" class="btn btn-info">
                  <i class='bx bxs-group'></i>
                 Khách hàng
                </a>
              </li>
              <li class="nav-item "  style="margin-left: 10px;">
                <form action="{{ route('searchTaiKhoan') }}" method="GET" class="form-search-custom">
                    <input type="text" class="form-control" style="width: 300px;" name="keyword" id="searchDanhMuc" placeholder="Từ khoá ..."  >
                    <button type="submit" class="btn btn-success"><i class='bx bx-search'></i></button>
                </form>
            </li>
            </ul>
           
              <!-- Basic Bootstrap Table -->
              <div class="card">
                 @if($errors->any()) 
                   		 @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                   		 @endforeach
              @endif
                          @if(session('error')) 
                              <label class="text-danger" style="color: #fc424a;margin: 10px;" >{{ session('error') }}</label>
                          @endif
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Ảnh đại diện</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Quyền</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="lstTaiKhoan">
                      @foreach ($lstTaiKhoan as $item)
                        <tr>
                          <td>
                            <div class="img">
                                <img src="{{ asset('storage/'.$item->anhDaiDien) }}" class="image-user " alt="{{ $item->hoTen }}">
                            </div>
                            
                          </td>
                          <td>{{ $item->hoTen }}</td>
                          <td>
                            {{ $item->email }}
                          </td>
                          <td>
                            {{ $item->soDienThoai }}
                          </td>
                          <td>
                            {{ $item->phanquyen->tenViTri }}
                          </td>
                          <td>
                            @if($item->deleted_at == null) <span class="badge bg-label-primary">Hoạt động</span>
                            @elseif($item->deleted_at != null) <span class="badge bg-label-danger">Đã khoá</span>
                            @endif
                          </td>
                          <td>
                           
                            @if($item->deleted_at == null)
                            <a class="btn btn-success" href="{{ route('user.edit', ['user' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>
                            </a>
                            <a class="btn btn-primary btn-change-password" data-bs-toggle="modal" data-bs-target="#modalCenter"  data-id="{{ $item->id }}" href="#">
                              <i class='bx bxs-key'></i>
                            </a>
                            <form class="d-inline-block" method="post" action="{{ route('user.destroy',['user'=>$item]) }}">
                              @csrf
                              @method("DELETE")
                              <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class='bx bx-lock' ></i></button>
                            </form>
                            @elseif($item->deleted_at != null) 
                            <a class="btn btn-success" href="{{ route('mokhoa',['user'=>$item]) }}">
                              <i class='bx bx-lock-open-alt'></i></i>
                            </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstTaiKhoan->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
            <div class="modal fade" id="modalCenter" tabindex="-1"  aria-modal="true" role="dialog">
              <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                  <h5 class="modal-title" id="modalCenterTitle">Đổi mật khẩu</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  
                  <div class="modal-body">
                      <form method="post" action="javascript:void(0)" id="form_changepassword" enctype="multipart/form-data">
                          <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="newpassword">Mật khẩu mới</label>
                            </div>
                            <div class="input-group input-group-merge">
                              <input type="password" id="newpassword" class="form-control" name="newpassword"
                                placeholder="Mật khẩu mới.........."
                                aria-describedby="password" />
                              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                          </div>
                           <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            </div>
                            <div class="input-group input-group-merge">
                              <input type="password" id="confirm_password" class="form-control" name="confirm_password"
                                placeholder="Nhập lại mật khẩu........"
                                aria-describedby="password" />
                              <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                          </div>
                          <input type="hidden" id="user_id" >
                          <button type="submit" class="btn btn-primary btn-change">Đổi mật khẩu</button>
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
@endsection
@section('js')
<script>
  $(function() {
    let lstRemoveProduct = document.querySelectorAll(".table-product tr");
    let lstSP = document.querySelectorAll(".product-search-item");
    let lstBtnDelete = document.querySelectorAll(".btn-xoa");
    let lstBtnUpdate = document.querySelectorAll(".btn-update");
    let lstBtnChangePassword = document.querySelectorAll(".btn-change-password");
    let btnChangePass = document.querySelector(".btn-change");

    //Đổi mật khẩu
    lstBtnChangePassword.forEach(item => item.addEventListener('click', function(e) {
      e.preventDefault();
      $("#user_id").val(item.dataset.id);
      btnChangePass.addEventListener('click', function() 
      {
        console.log("a");
        $.ajax({
          type: "POST",
          url: "/admin/doi-mat-khau",
          data: {
              _token: $("#token").val(),
             newpassword: $("#newpassword").val(),
             user_id: $("#user_id").val(),
             confirm_password: $("#confirm_password").val()
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
          
          //Search DiaDanh
        $('#searchInput').on('keyup', function() {
              var val = $('#searchInput').val();
              if(val != "") {
                  $.ajax({
                  type: "get",
                  url: "/admin/taikhoan/timkiem",
                  data: {
                      txtSearch: val
                  },
                  dataType: "json",
                  success: function (response) {
                    $("#lstTaiKhoan").html(response);
                  }
              });
              }
              
          });


        

    });


</script>

@endsection