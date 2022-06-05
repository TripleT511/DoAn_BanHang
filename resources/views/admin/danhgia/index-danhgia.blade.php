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
                        <th>sanpham_id</th>                    
                        <th>taikhoan_id</th>
                        <th>Noi dung</th>
                        <th>Xep Hang</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($lstDanhGia as $item)
                      <tr>
                      </td>
                        <td><strong>{{ $item->san_pham_id }}</strong>
                      </td>
                      </td>
                        <td><strong>{{ $item->user_id }}</strong>
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
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
@endsection