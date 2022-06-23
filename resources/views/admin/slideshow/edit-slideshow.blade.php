@extends('layouts.admin')

@section('title','Chỉnh sửa SlideShow')
@section('css')
    <style>
        .list-preview-image {
            display: flex;
            align-content: center;
            gap: 10px;
        }
        .preview-image-item {
            width: 150px;
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">SlideShow/</span> Sửa SlideShow</h4>
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
                <form method="post" action="{{ route('slider.update', ['slider' => $slider]) }}" enctype="multipart/form-data">
                @csrf
                    @method("PATCH")
                    @if($slider->trangThai == 1) <input class="form-check-input" type="checkbox" name="trangThai" value="" id="defaultCheck1" checked><span>  hiển thị slideshow</span>
                   @else  <input class="form-check-input" type="checkbox" name="trangThai" value="" id="defaultCheck1"><span>  hiển thị slideshow</span>
                    @endif
                <div class="mb-3">
                    <label class="form-label" for="tieuDe">Tiêu Đề</label>
                    <input type="text" name="tieuDe" class="form-control" id="tieuDe"value="{{ $slider->tieuDe }}" placeholder="Nhập Tiêu Đề SlideShow" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noiDung">Nội Dung</label>
                    <input type="text" name="noiDung" class="form-control" id="noiDung" value="{{ $slider->noiDung }}" placeholder="Nhập Nội dung SlideShow" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug"value="{{ $slider->slug }}" placeholder="Nhập Slug" />
                </div>
                <div class="mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input class="form-control" type="file" id="hinhAnh" name="hinhAnh">
                </div>
                <div class="mb-3">
                    <div class="list-preview-image">
                        <div class="preview-image-item">
                            <img alt="Avatar" src="{{ asset('storage/'.$slider->hinhAnh) }}" alt="imgPreview" id="imgPreview">
                        </div>
                    </div>
                </div>
                   
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <button type="button" class="btn btn-dark" onclick="history.back()">Thoát</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection
@section('js')
    <script src="https://cdn.tiny.cloud/1/c4yq515bjllc9t8mkucpjw8rmw5jnuktk654ihvvk2k4ve5f/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>

        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === wysiwyg Editor === // 
        tinymce.init({
            selector: '#noiDung',
            plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            language: 'vi'
            });
    </script>
@endsection