@extends('layouts.admin')

@section('title','Quản lý phân quyền')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3">Phân quyền</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('phanquyen.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
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
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstPhanQuyen as $item)
                        <tr>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->tenViTri }}</strong></td>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{ $item->viTri }}</td>
                          <td>
                            <a class="btn btn-success" href="{{ route('phanquyen.edit', ['phanquyen' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>Sửa
                            </a>
                            <form class="d-inline-block" method="post" action="{{ route('phanquyen.destroy', ['phanquyen'=>$item]) }}">
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