@extends('layouts.admin')

@section('title','Chỉnh sửa Danh Mục Sản Phẩm')
@section('css')
    <style>
        .list-preview-image {
            display: flex;
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

        
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Sửa Danh Mục Sản Phẩm</h4>
    <!-- Basic Layout -->
    <div class="row">
        
        <div class="col-xl">
            <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            </div>
            <div class="card-body">
            @if($errors->any()) 
                    @foreach ($errors->all() as $err)
                        <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                    @endforeach
                @endif
                <form method="post" action="{{ route('danhmuc.update', ['danhmuc'=> $danhmuc]) }}"enctype="multipart/form-data">
                @csrf
                    @method("PATCH")
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Danh Mục Sản Phẩm</label>
                    <input type="text" name="tenDanhMuc" class="form-control" id="basic-default-fullname"value="{{ $danhmuc->tenDanhMuc }}"  placeholder="Nhập tên Danh Mục Sản Phẩm" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Slug</label>
                    <input type="text" name="slug" class="form-control" id="basic-default-fullname" value="{{ $danhmuc->slug }}" placeholder="Nhập liên kết danh mục" />
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Danh mục cha</label>
                    <select id="defaultSelect" name="idDanhMucCha" class="form-select">
                        <option value="">Chọn danh mục cha</option>
                        @foreach($danhMucCha as $dm)
                        <option value="{{$dm->id}}" {{ ($danhmuc->idDanhMucCha == $dm->id) ? 'selected' : '' }}>{{$dm->tenDanhMuc}}</option>
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
                            <img src="{{ asset('storage/'.$danhmuc->hinhAnh) }}" alt="imgPreview" id="imgPreview">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-dark"onclick="history.back()">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
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
</script>
@endsection