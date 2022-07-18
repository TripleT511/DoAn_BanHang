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
      
       .modal-backdrop.fade {
        display: none;
      } 
      .modal-backdrop.show {
        z-index: 1089;
        display: block;
      }
      .modal-dialog {
        max-width: 80%;
        width: 80%;
      }
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3">Slider</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('slider.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
              <li class="nav-item "  style="margin-left: 10px;">
                <form action="{{ route('searchSlideShow') }}" method="GET" class="form-search-custom">
                    <input type="text" class="form-control" name="keyword" id="searchDanhMuc" placeholder="Từ khoá ..."  >
                    <button type="submit" class="btn btn-success"><i class='bx bx-search'></i></button>
                </form>
            </li>
            </ul>
              <!-- Basic Bootstrap Table -->
              <div class="card">
               
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>  
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="lstSlideshow"> 
                    @foreach ($lstSlider as $item)
                      <tr> 
                        <td>
                          <div class="img">
                              <img src="{{ asset('storage/'.$item->hinhAnh) }}" class="image-product" alt="{{ $item->tieuDe }}">
                          </div>
                        </td>
                        <td> {{ $item->tieuDe }}</td>
                        <td>@if($item->trangThai == 1) <span class="badge bg-label-primary">hiển thị</span>
                           @else <span class="badge bg-label-danger">không hiển thị</span> @endif </td>
                        <td>
                          <a class="btn btn-success" href="{{ route('slider.edit', ['slider' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>
                          </a>
                           <button type="button"  class="btn btn-danger btn-delete-slider" data-route="{{ route('slider.destroy', ['slider'=>$item]) }}" data-bs-toggle="modal" data-bs-target="#basicModal">
                            <i class="bx bx-trash me-1"></i>
                          </button>
                        </td>
                      </tr>
                     
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstSlider->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Basic Bootstrap Table -->

              
              <!--/ Responsive Table -->
            </div>
<div class="modal-backdrop fade "></div>
{{-- Model Delete --}}
<div class="modal fade" id="basicModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 30%; width: 30%;">
    <div class="modal-content">
      <div class="modal-header justify-content-center py-4">
        <h5 class="modal-title text-center w-100" id="exampleModalLabel1">Bạn có chắc chắn muốn xoá không ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" >
         Đóng
        </button>
         <form class="d-inline-block" method="post" id="form-delete" action="">
          @csrf
          @method("DELETE")
          <button style="outline: none; border: none" class="btn btn-danger" type="submit"> Xác nhận </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
   let lstBtnDeleteRoute = document.querySelectorAll(".btn-delete-slider");
  lstBtnDeleteRoute.forEach((item) => item.addEventListener("click", function() {
    let linkRoute = item.dataset.route;
    let formDel = document.querySelector("#form-delete");
    formDel.action  = linkRoute;
  }));

</script>

@endsection