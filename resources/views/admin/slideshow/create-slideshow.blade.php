@extends('layouts.admin')

@section('title','Thêm SlideShow')
@section('css')
    <style>
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
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">SlideShow/</span> Thêm SlideShow</h4>
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
                <form method="post" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="tieuDe">Tiêu Đề</label>
                    <input type="text" name="tieuDe" class="form-control" id="basic-default-fullname" placeholder="Nhập Tiêu Đề SlideShow" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noiDung">Nội Dung</label>
                    <textarea name="noiDung" id="noiDung" class="form-control noidung">
                    </textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label" for="slug">slug</label>
                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Nhập slug..." />
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
                <button type="submit" class="btn btn-primary">Thêm</button>
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

        // === CK Editor === // 
      
        tinymce.init({
            selector: '#noiDung',
            plugins: 'a11ychecker advcode casechange export formatpainter image  editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table insertfile tableofcontents undo redo link',
            image_title: true,
            automatic_uploads: true,
            file_picker_callback: function (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                let type = 'image' === meta.filetype ? 'Images' : 'Files',
                    url  = '/laravel-filemanager?editor=tinymce5&type=' + type;

                tinymce.activeEditor.windowManager.openUrl({
                    url : url,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            },
            toolbar_mode: 'floating',
            language: 'vi'
        });
    </script>
@endsection