@extends('layouts.admin')

@section('title','Quản lý Thuộc Tính')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
                        
            <h4 class="fw-bold py-3">Thuộc tính</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
             
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
                            <i class="bx bx-edit-alt me-1"></i>
                          </a>
                        </td>
                      </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstThuocTinh->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
            
@endsection