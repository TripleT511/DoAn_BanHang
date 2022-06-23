@extends('layouts.admin')

@section('title','Quản lý Hoá Đơn')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng Hoá Đơn</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
             
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách Hoá Đơn</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Họ tên</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày xuất hoá đơn</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>  
                        <th>Hành động</th>               
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstHoaDon as $item)
                      <tr>
                        <td>{{ $item->hoTen }}</td>
                        <td>
                          {{ $item->diaChi }}
                        </td>
                        <td>
                          {{ $item->email }}
                        </td>
                        <td>
                          {{ $item->soDienThoai }}
                        </td>
                        <td>
                          {{ 
                          date('d-m-Y', strtotime($item->ngayXuatHD))
                          }}
                        </td>
                        <td>
                          @if($item->trangThai == 0) <span class="badge bg-label-primary">Chờ xác nhận</span>
                          @elseif($item->trangThai == 1) <span class="badge bg-label-info">Đã xác nhận</span>
                          @elseif($item->trangThai == 2) <span class="badge bg-label-dark">Chờ giao hàng</span>
                          @elseif($item->trangThai == 3) <span class="badge bg-label-warning">Đang giao hàng</span>
                          @elseif($item->trangThai == 4) <span class="badge bg-label-success">Hoàn thành</span>
                          @elseif($item->trangThai == 5) <span class="badge bg-label-danger">Đã huỷ</span>
                          @endif
                        </td>
                        <td>
                          {{ $item->tongTien }}
                        </td>
                        <td>
                          @if($item->trangThai == 0)
                            <a class="btn btn-primary" href="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>Xác nhận
                            </a>
                          @elseif($item->trangThai == 1) 
                            <a class="btn btn-primary" href="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>Đóng gói
                            </a>
                          @elseif($item->trangThai == 2) 
                            <a class="btn btn-primary" href="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                              <i class="bx bx-edit-alt me-1"></i>Vận chuyển
                            </a>
                          @endif

                          @if($item->trangThai != 4)
                          <form class="d-inline-block" method="post" action="{{ route('hoadon.destroy', ['hoadon'=>$item]) }}">
                            @csrf
                            @method("DELETE")
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i> Huỷ</button>
                          </form>
                          @endif
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
                  {!!$lstHoaDon->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
@endsection