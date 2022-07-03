@extends('layouts.admin')

@section('title','Quản lý Hoá Đơn')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
             <h4 class="fw-bold py-3">Đơn hàng</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
               
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Họ tên</th>
                       
                        <th>Email</th>
                      
                        <th>Ngày xuất hoá đơn</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>  
                        <th>Hành động</th>               
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstHoaDon as $item)
                      <tr>
                        <td>{{ $item->hoTen }}</td>
                    
                        <td>
                          {{ $item->email }}
                        </td>
                       
                        <td>
                          {{ 
                          date('d-m-Y', strtotime($item->ngayXuatHD))
                          }}
                        </td>
                        <td>
                          {{ $item->tongTien }}
                        </td>
                         <td>
                          @if($item->trangThaiThanhToan == 0) <span class="badge bg-label-dark">Chưa thanh toán</span>
                          @elseif($item->trangThaiThanhToan == 1) <span class="badge bg-label-success">Đã thanh toán</span>
                          @endif
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
                          @if($item->trangThai == 0)
                          <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="1">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i> Xác nhận</button>
                          </form>
                          @elseif($item->trangThai == 1) 
                           <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="2">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i>Đóng gói</button>
                          </form>
                          @elseif($item->trangThai == 2) 
                            <form class="d-inline-block" method="post" action="{{ route('hoadon.update', ['hoadon' => $item]) }}">
                            @csrf
                            @method("PATCH")
                            <input type="hidden" name="page_on" value="{{ $lstHoaDon->currentPage() }}">
                            <input type="hidden" name="trangThai" value="3">
                            <button style="outline: none; border: none" class="btn btn-primary" type="submit"><i class="bx bx-trash me-1"></i> Vận chuyển</button>
                          </form>
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