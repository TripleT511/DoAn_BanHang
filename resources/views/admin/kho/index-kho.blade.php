@extends('layouts.admin')

@section('title','Quản lý kho')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng phiếu kho</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('phieukho.create') }}">
                    <i class='bx bx-plus'></i> Thêm phiếu kho</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách phiếu</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Phiếu</th>
                        <th>Ngày</th>
                        <th>Mã phiếu</th>
                        <th>Người tạo</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstPhieu as $item)
                        <tr>
                          {{-- <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $item->tenViTri }}</strong></td>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{ $item->viTri }}</td>
                          <td> --}}
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"
                                  ><i class="bx bx-edit-alt me-1"></i>Sửa</a>
                                <a class="dropdown-item" href="javascript:void(0);"
                                  ><i class="bx bx-trash me-1"></i> Xoá</a>
                              </div>
                            </div>
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