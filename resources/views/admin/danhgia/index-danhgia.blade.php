@extends('layouts.admin')

@section('title','Quản lý Đánh Giá')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng Đánh Giá</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('danhgia.create') }}"><i class="bx bx-user me-1"></i> Thêm Đánh Giá</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách Đánh Giá</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>tên sản phẩm</th>                    
                        <th>họ và tên</th>
                        <th>Noi dung</th>
                        <th>Xep Hang</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="lstBinhLuan">
                    @foreach ($lstDanhGia as $item)
                      <tr>
                      </td>
                        <td><strong>{{ $item->sanpham->tenSanPham }}</strong>
                      </td>
                      </td>
                        <td><strong>{{ $item->taikhoan->hoTen }}</strong>
                      </td>
                      </td>
                        <td><strong>{{ $item->noiDung }}</strong>
                      </td>
                      </td>
                        <td><strong>{{ $item->xepHang }}</strong>
                      </td>
                      <td>
                          <form class="d-inline-block" method="post" action="{{ route('danhgia.destroy', ['danhgium' => $item]) }}">
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
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstDanhGia->withQueryString()->links() !!}
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
                    url: "/admin/binhluan/timkiem",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                    
                      $("#lstBinhLuan").html(response); 
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