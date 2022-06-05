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