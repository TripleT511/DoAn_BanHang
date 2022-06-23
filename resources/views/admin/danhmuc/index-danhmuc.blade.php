@extends('layouts.admin')

@section('title','Quản lý Danh Mục Sản Phẩm')
@section('css')
    <style>
      .img {
        width: 60px;
        position: relative;
      }
      .image-product {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
      
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3">Danh Mục Sản Phẩm</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('danhmuc.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Tên Danh Mục</th>
                        <th>Danh Mục Cha</th>                    
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="DanhMuc">
                      <?php
                        dequyDanhMuc($lstDanhMuc);
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstDanhMuc->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Basic Bootstrap Table -->
<?php
function dequyDanhMuc($danhmuc, $idDanhMucCha = 0, $char = '')
    {
        foreach ($danhmuc as $key => $item) {
            // Nếu là chuyên mục con thì hiển thị
            if ($item->idDanhMucCha == $idDanhMucCha) {
              ?>
              <tr>
                 <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $char . $item->tenDanhMuc }}</strong></td>
                 <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{ $item->idDanhMucCha }}</td>
                       <td>
                          <a class="btn btn-success" href="{{ route('danhmuc.edit', ['danhmuc' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>Sửa
                          </a>
                          <form class="d-inline-block" method="post" action="{{ route('danhmuc.destroy', ['danhmuc'=>$item]) }}">
                            @csrf
                            @method("DELETE")
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Xoá</button>
                          </form>
                        </td>
              </tr>
              <?php

                // Xóa chuyên mục đã lặp
                unset($danhmuc[$key]);

                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                dequyDanhMuc($danhmuc, $item->id, $char . '|-- ');
            }
        }
    }
?>
              
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
                    url: "/admin/dmuc/timkiem",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                      $("#DanhMuc").html(response);
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