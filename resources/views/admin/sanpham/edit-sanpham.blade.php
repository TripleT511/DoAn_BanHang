@extends('layouts.admin')

@section('title','Sửa Sản Phẩm')
@section('css')
    <style>
        .list-preview-image {
            display: flex;
            align-content: center;
            gap: 10px;
        }
        .preview-image-item {
            width: 100px;
            height: 150px;
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
    <h4 class="fw-bold py-3 mb-4">Sửa Sản Phẩm</h4>
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
                <form method="post" action="{{ route('sanpham.update', ['sanpham' => $sanpham]) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Sản Phẩm</label>
                    <input type="text" name="tenSanPham" class="form-control" id="basic-default-fullname" value="{{ $sanpham->tenSanPham }}" placeholder="Nhập tên sản phẩm..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mã sản phẩm</label>
                    <input type="text" name="maSKU" class="form-control" id="basic-default-fullname" 
                    value="{{ $sanpham->sku }}" placeholder="Nhập mã sản phẩm (SKU) nếu có..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mô Tả</label>
                    <textarea name="moTa" id="moTa" 
                     class="form-control moTa">
                     {{ $sanpham->moTa }}
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Nội dung</label>
                    <textarea name="noiDung" id="noiDung" 
                     class="form-control noidung-sp">
                     {{ $sanpham->noiDung }}
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Đặc trưng</label>
                    <select id="defaultSelect" name="dacTrung" class="form-select">
                        <option value="0">Chọn đặc trưng</option>
                        <option value="1" @if ($sanpham->dacTrung == 1) selected @endif>Sản phẩm bán chạy</option>
                        <option value="2" @if ($sanpham->dacTrung == 2) selected @endif>Sản phẩm hot</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Giá</label>
                    <input type="text" name="gia" class="form-control" value="{{ $sanpham->gia }}"  id="basic-default-fullname" placeholder="Nhập giá..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Giá khuyến mãi</label>
                    <input type="text" name="giaKhuyenMai" class="form-control" 
                    value="{{ $sanpham->giaKhuyenMai }}" id="basic-default-fullname" placeholder="Nhập giá khuyến mãi ..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Slug</label>
                    <input type="text" name="slug" class="form-control" 
                    value="{{ $sanpham->slug }}" id="basic-default-fullname" placeholder="Nhập slug ..." />
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Danh mục sản phẩm</label>
                    <select id="defaultSelect" name="danhmucid" class="form-select">
                        <option value="">Chọn danh mục sản phẩm</option>
                        @foreach($lstDanhMuc as $dm)
                        <option value="{{$dm->id}}" {{ $sanpham->danh_muc_id == $dm->id ? 'selected' : '' }} >{{$dm->tenDanhMuc}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input class="form-control" type="file" id="hinhAnh" name="hinhAnh[]" multiple>
                </div>
                <div class="mb-3">
                    <div class="list-preview-image">
                        @foreach ($lstHinhAnh as $item2)
                        <div class="preview-image-item">
                            <img src="{{ asset('storage/'.$item2->hinhAnh) }}" alt="imgPreview"
                            id="imgPreview2">
                        </div>
                        @endforeach
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

    <script>

        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
                var divShowImage = document.querySelector(".list-preview-image");
                divShowImage.innerHTML = "";
                var dataFile = e.target.files;
                for(var i = 0; i < dataFile.length; i++) {
                    var filePath = URL.createObjectURL(dataFile[i]);
                    var divTag = document.createElement("div");
                    divTag.classList.add("preview-image-item");
                    var imgTag = document.createElement("img");
                    imgTag.src = filePath;
                    divTag.appendChild(imgTag);
                    divShowImage.appendChild(divTag);
                }
            });

        // === Preview Image === // 

        // === CK Editor === // 
        tinymce.init({
            selector: '#moTa',
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