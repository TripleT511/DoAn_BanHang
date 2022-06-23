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
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>Bảng Tài Khoản</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('user.create') }}"><i class="bx bx-user me-1"></i> Thêm tài khoản nhân viên</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.index', ['block' => true]) }}" class="btn btn-danger">
                  <i class='bx bx-trash-alt'></i>
                  Tài khoản bị khoá
                </a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh Sách Tài Khoản</h5>
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
                              <i class="bx bx-edit-alt me-1"></i>Sửa
                            </a>
                            <form class="d-inline-block" method="post" action="{{ route('user.destroy',['user'=>$item]) }}">
                              @csrf
                              @method("DELETE")
                              <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class='bx bx-lock' ></i> Khoá</button>
                            </form>
                            @elseif($item->deleted_at != null) 
                            <a class="btn btn-success" href="{{ route('mokhoa',['user'=>$item]) }}">
                              <i class='bx bx-lock-open-alt'></i></i>Mở khoá
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
@endsection
@section('js')
<script>
    $(function() {
      let lstRemoveProduct = document.querySelectorAll(".table-product tr");
        let lstSP = document.querySelectorAll(".product-search-item");
        let lstBtnDelete = document.querySelectorAll(".btn-xoa");
        let lstBtnUpdate = document.querySelectorAll(".btn-update");

            
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

           

          

            // function renderUI() {
            //     $("#searchSlider").val('');
            //     $.ajax({
            //         type: "get",
            //         url: "/admin/slideshow/xem-chi-tiet",
            //         dataType: "json",
            //         success: function (response) {
            //             $(".table-product").html(response);
            //             lstBtnDelete = document.querySelectorAll(".btn-xoa");
            //             lstBtnUpdate = document.querySelectorAll(".btn-update");
            //             let lstSoLuong = document.querySelectorAll(".input-sl");
            //             let lstGia = document.querySelectorAll(".input-gia");

            //              // Xoá chi tiết phiếu kho
            //             lstBtnDelete.forEach(item => item.addEventListener('click', function () {
            //                     $.ajax({
            //                         type: "get",
            //                         url: "/admin/kho/xoa-chi-tiet",
            //                         dataType: "json",
            //                         data: {
            //                             id: item.dataset.id
            //                         },
            //                         success: function (response) {
            //                            renderUI();
            //                         }
            //                     });
            //             }));

            //             // Cập nhật chi tiết phiếu kho
            //             lstBtnUpdate.forEach((item, index) => item.addEventListener('click', function () {
            //                 if(lstSoLuong[index].value <= 0 || isNaN(lstSoLuong[index].value) || isNaN(lstGia[index].value) || lstGia[index].value <= 0) {
            //                     document.querySelector(".bs-toast").classList.add("bg-danger");
            //                     document.querySelector(".bs-toast").classList.remove("bg-success");
            //                     document.querySelector(".toast-body").innerText = "Lỗi";
            //                     document.querySelector(".bs-toast").classList.add("show");
            //                     setTimeout(() => {
            //                         document.querySelector(".bs-toast").classList.remove("show");
            //                     }, 2000);
            //                 } else {
            //                     $.ajax({
            //                         type: "get",
            //                         url: "/admin/kho/cap-nhat-chi-tiet",
            //                         dataType: "json",
            //                         data: {
            //                             id: item.dataset.id,
            //                             soluong: lstSoLuong[index].value,
            //                             gia: lstGia[index].value
            //                         },
            //                         success: function (response) {
            //                             document.querySelector(".bs-toast").classList.remove("bg-danger");
            //                             document.querySelector(".bs-toast").classList.add("bg-success");
            //                             document.querySelector(".toast-body").innerText = "Cập nhật thành công";

            //                             document.querySelector(".bs-toast").classList.add("show");
            //                             setTimeout(() => {
            //                                 document.querySelector(".bs-toast").classList.remove("show");
            //                             }, 2000);
            //                            renderUI();
            //                         }
            //                     });
            //                 }
                                
            //             }))
            //         }
            //     });
            // }  
    });


</script>

@endsection