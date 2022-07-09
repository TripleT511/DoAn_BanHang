@extends('layouts.admin')

@section('title','Quản lý Sản Phẩm')
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
            <h4 class="fw-bold py-3">Sản Phẩm</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('sanpham.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh mục</th></th>
                        <th>Giá</th>
                        <th>Giá khuyến mãi</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>              
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($lstSanPham as $item)
                      <tr>
                        <td>
                          <div class="img">
                            @foreach ($item->hinhanhs as $key => $item2)
                              @if($key == 1) <?php break; ?> @endif
                                <img src="{{ asset('storage/'.$item2->hinhAnh) }}" class="image-product" alt="{{ $item->tenSanPham }}">
                            @endforeach
                          </div>
                          
                        </td>
                        <td><strong>
                          <a href="{{ route('chitietsanpham', ['slug' => $item->slug]) }}" target="_blank">
                          {{ $item->tenSanPham }}
                        </a>  
                        </strong></td>
                        <td>
                          {{ $item->danhmuc->tenDanhMuc }}
                        </td>
                        <td>
                          {{ number_format($item->gia, 0, '', ',') }} ₫
                        </td>
                        <td>
                          {{ number_format($item->giaKhuyenMai, 0, '', ',') }} ₫
                        </td>
                        <td>
                          @if($item->tonKho > 0) 
                            <span class="badge bg-label-success">Còn hàng</span>
                          @else
                            <span class="badge bg-label-danger">Hết hàng</span>
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-success" href="{{ route('sanpham.edit', ['sanpham' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>
                          </a>
                          <form class="d-inline-block" method="post" action="{{ route('sanpham.destroy', ['sanpham'=>$item]) }}">
                            @csrf
                            @method("DELETE")
                            <button style="outline: none; border: none" class="btn btn-danger" type="submit"><i class="bx bx-trash me-1"></i></button>
                          </form>
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
                  {!!$lstSanPham->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
@endsection