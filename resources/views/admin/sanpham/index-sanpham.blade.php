@extends('layouts.admin')

@section('title','Quản lý Sản Phẩm')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng Sản Phẩm</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('phanQuyen.create') }}"><i class="bx bx-user me-1"></i> Thêm Sản Phẩm</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách Sản Phẩm</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Hình Ảnh</th>
                        <th>Mô tả</th>
                        <th>Đặc trưng</th>
                        <th>Chất Liệu</th>
                        <th>Màu Sắc</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Hành Động</th>              
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
                        <td><img src="{ asset('ad/assets/img/avatars/5.png') }}" class="card-img-top" style="width:300px;max-height:300px;object-fit:contain"></td>
                        <td>Albert Cook</td>
                        <td>dac trung</td>
                        <td>vai to tam</td>
                        <td>vang</td>
                        <td>10</td>
                        <td>10.000.000.000 vnd</td>
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
                     
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
@endsection