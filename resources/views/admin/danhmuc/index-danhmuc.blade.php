@extends('layouts.admin')

@section('title','Quản lý Danh Mục Sản Phẩm')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng Danh Mục Sản Phẩm</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('danhmuc.create') }}"><i class="bx bx-user me-1"></i> Thêm Danh Mục Sản Phẩm</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách danh mục sản phẩm</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Tên Danh Mục</th>
                        <th>Danh Mục Cha</th>                    
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <?php
                        dequyDanhMuc($lstDanhMuc);
                      ?>
                    </tbody>
                  </table>
                </div>
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
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-edit-alt me-1"></i>Sửa</a
                      >
                      <a class="dropdown-item" href="javascript:void(0);"
                        ><i class="bx bx-trash me-1"></i> Xoá</a
                      >
                    </div>
                  </div>
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