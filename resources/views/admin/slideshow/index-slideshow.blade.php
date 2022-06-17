@extends('layouts.admin')

@section('title','Quản lý Loại slideshow')
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Bảng slideshow</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('slider.create') }}"><i class="bx bx-user me-1"></i> Thêm slideshow</a>
              </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">Danh sách slideshow</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>       
                        <th>Url</th>    
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($lstSlider as $item)
                      <tr>
                        <td>
                          <div class="img">
                              <img src="{{ asset('storage/'.$item->hinhAnh) }}" class="image-product" alt="{{ $item->tieuDe }}">
                          </div>
                        </td>
                        <td>
                          {{ $item->tieuDe }}
                        </td>
                        <td>
                          {{ $item->slug }}
                        </td>
                        <td>
                          <a class="btn btn-success" href="{{ route('slider.edit', ['slider' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>Sửa
                          </a>
                          <form class="d-inline-block" method="post" action="{{ route('slider.destroy', ['slider'=>$item]) }}">
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