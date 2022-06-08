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
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Thêm tài khoản</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Table Basic</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Ảnh đại diện</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Quyền</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
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
                            <a class="btn btn-success" href="{{ route('taikhoan.edit', ['taikhoan' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>Sửa
                            </a>
                            <form class="d-inline-block" method="post" action="{{ route('taikhoan.destroy', ['taikhoan'=>$item]) }}">
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
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
@endsection