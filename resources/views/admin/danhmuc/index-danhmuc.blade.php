@extends('layouts.admin')

@section('title','Quản lý Danh Mục Sản Phẩm')
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
      .list-preview-image {
            display: none;
            align-content: center;
            gap: 10px;
        }
        .preview-image-item {
            width: 100px;
            height: 100px;
            padding: 5px;
            position: relative;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #d7d7d7;
        }

        .preview-image-item img {
            display: flex;
            margin: auto;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .img {
        position: relative;
        width: 50px;
        height: 50px;
        padding: 5px;
        }

        .img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: flex;
        margin: auto;
      }
      
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3">Danh Mục Sản Phẩm</h4>
  <div class="card mb-4">
    <div class="card-body">
      @if($errors->any()) 
          @foreach ($errors->all() as $err)
              <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
          @endforeach
      @endif
      <form method="post" action="{{ route('danhmuc.store') }}">
          @csrf
      <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Tên Danh Mục Sản Phẩm</label>
          <input type="text" name="tenDanhMuc" class="form-control" id="basic-default-fullname" placeholder="Nhập tên Danh Mục Sản Phẩm" />
      </div>
      <div class="mb-3">
          <label class="form-label" for="basic-default-fullname">Slug</label>
          <input type="text" name="slug" class="form-control" id="basic-default-fullname" placeholder="Nhập liên kết danh mục" />
      </div>
      <div class="mb-3">
          <label for="defaultSelect" class="form-label">Danh mục cha</label>
          <select id="defaultSelect" name="idDanhMucCha" class="form-select">
              <option value="">Chọn danh mục cha</option>
              @foreach($danhMucCha as $dm)
              <option value="{{$dm->id}}">{{$dm->tenDanhMuc}}</option>
              @endforeach
          </select>
      </div>
      <div class="mb-3">
          <label for="hinhAnh" class="form-label">Hình Ảnh</label>
          <input class="form-control" type="file" id="hinhAnh" name="hinhAnh">
      </div>
      <div class="mb-3">
          <div class="list-preview-image">
              <div class="preview-image-item">
                  <img src="" alt="imgPreview" id="imgPreview">
              </div>
          </div>
      </div>
      <button type="submit" class="btn btn-primary">Lưu</button>
      </form>
    </div>
  </div>
  <ul class="nav nav-pills flex-column flex-md-row mb-3 justify-content-end">
    <li class="nav-item "  style="margin-left: 10px;">
        <form action="{{ route('searchDanhMuc') }}" method="GET" class="form-search-custom">
            <input type="text" class="form-control" name="keyword" id="searchDanhMuc" placeholder="Từ khoá ..."  >
            <button type="submit" class="btn btn-success"><i class='bx bx-search'></i></button>
        </form>
    </li>
  </ul>
  <div class="card">
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Hình ảnh</th>
            <th>Tên Danh Mục</th>              
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0" id="DanhMuc">
          <?php
            dequyDanhMuc($lstDanhMuc);
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="pagination__wrapper">
    <ul class="pagination">
      {{-- {!!$lstDanhMuc->withQueryString()->links() !!} --}}
    </ul>
  </div>
  <div class="modal-backdrop fade "></div>
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
  <?php
function dequyDanhMuc($danhmuc, $idDanhMucCha = 0, $char = '')
    {
        foreach ($danhmuc as $key => $item) {
            // Nếu là chuyên mục con thì hiển thị
            if ($item->idDanhMucCha == $idDanhMucCha) {
              ?>
              <tr>
                <td>
                  <div class="img">
                    <img src="{{ asset('storage/'.$item->hinhAnh) }}" alt="{{ $item->tenDanhMuc }}">
                  </div>
                </td>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $char . $item->tenDanhMuc }}</strong></td>
                <td>
                  <a class="btn btn-success" href="{{ route('danhmuc.edit', ['danhmuc' => $item]) }}">
                    <i class="bx bx-edit-alt me-1"></i>
                  </a>
                   <button type="button"  class="btn btn-danger btn-delete-danhmuc" data-route="{{ route('danhmuc.destroy', ['danhmuc'=>$item]) }}" data-bs-toggle="modal" data-bs-target="#basicModal">
                          <i class="bx bx-trash me-1"></i>
                          </button>
                </td>
              </tr>
              <?php

                // Xóa chuyên mục đã lặp
                unset($danhmuc[$key]);

                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                dequyDanhMuc($danhmuc, $item->id, $char . '|-- ');
            }
        }
    }
?>
</div>

@endsection
@section('js')
<script>
// === Preview Image === // 
       
$("#hinhAnh").on("change", function (e) {
        var filePath = URL.createObjectURL(e.target.files[0]);
        $(".list-preview-image").css('display', 'flex');
        
        $("#imgPreview").show().attr("src", filePath);
        
    });

// === Preview Image === // 

let lstBtnDeleteRoute = document.querySelectorAll(".btn-delete-danhmuc");
      lstBtnDeleteRoute.forEach((item) => item.addEventListener("click", function() {
        let linkRoute = item.dataset.route;
        let formDel = document.querySelector("#form-delete");
        formDel.action  = linkRoute;
      }));
</script>
@endsection