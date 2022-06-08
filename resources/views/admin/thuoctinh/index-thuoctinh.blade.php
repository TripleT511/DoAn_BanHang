@extends('layouts.admin')

@section('title','Quản lý Thuộc Tính')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng Thuộc Tính</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('thuoctinh.create') }}"><i class="bx bx-user me-1"></i> Thêm Thuộc Tính</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách Thuộc Tính</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Tên Thuộc Tính</th>
                        <th>Loại thuộc tính</th>
                        <th>Hành động</th>              
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstThuocTinh as $item)
                      <tr>
                        <td>
                          {{ $item->tenThuocTinh }}
                        </td>
                        <td>
                          {{ $item->loaiThuocTinh }}
                        </td>
                        <td>
                          <a class="btn btn-success" href="{{ route('thuoctinh.edit', ['thuoctinh' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>Sửa
                          </a>
                          <form class="d-inline-block" method="post" action="{{ route('thuoctinh.destroy', ['thuoctinh'=>$item]) }}">
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