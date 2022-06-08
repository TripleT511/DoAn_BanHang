@extends('layouts.admin')

@section('title','Thêm Sản Phẩm')
@section('css')
    <style>
        .list-preview-image {
            display: none;
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
        .attr-item {
            gap: 10px;
            flex-wrap: wrap;
            margin: 10px;
        }
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sản Phẩm/</span> Thêm Sản Phẩm</h4>
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
                <form method="post" action="{{ route('sanpham.store') }}" enctype="multipart/form-data">
                    @csrf
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Sản Phẩm</label>
                    <input type="text" name="tenSanPham" class="form-control" id="basic-default-fullname" placeholder="Nhập tên sản phẩm..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mã sản phẩm</label>
                    <input type="text" name="maSKU" class="form-control" id="basic-default-fullname" placeholder="Nhập mã sản phẩm (SKU) nếu có..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mô Tả</label>
                    <textarea name="moTa" id="moTa" class="form-control moTa">
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Nội dung</label>
                    <textarea name="noiDung" id="noiDung" class="form-control noidung-sp">
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Đặc trưng</label>
                    <select id="defaultSelect" name="dacTrung" class="form-select">
                        <option value="0">Chọn đặc trưng</option>
                        <option value="1">Sản phẩm mới</option>
                        <option value="2">Sản phẩm hot</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Giá</label>
                    <input type="text" name="gia" class="form-control" id="basic-default-fullname" placeholder="Nhập giá..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Giá khuyến mãi</label>
                    <input type="text" name="giaKhuyenMai" class="form-control" id="basic-default-fullname" placeholder="Nhập giá khuyến mãi ..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Slug</label>
                    <input type="text" name="slug" class="form-control" id="basic-default-fullname" placeholder="Nhập slug ..." />
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Danh mục sản phẩm</label>
                    <select id="defaultSelect" name="danhmucid" class="form-select">
                        <option value="0">Chọn danh mục sản phẩm</option>
                        @foreach($lstDanhMuc as $dm)
                        <option value="{{$dm->id}}">{{$dm->tenDanhMuc}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input class="form-control" type="file" id="hinhAnh" name="hinhAnh[]" multiple>
                </div>
                <div class="mb-3">
                    <div class="list-preview-image">
                        <div class="preview-image-item">
                            <img src="" alt="imgPreview" id="imgPreview1">
                        </div>
                        <div class="preview-image-item">
                            <img src="" alt="imgPreview"
                            id="imgPreview2">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="lstThuocTinh" class="form-label">Các Thuộc tính</label>
                    <input class="form-control" list="datalistOptions" id="lstThuocTinh" placeholder="Chọn thuộc tính" >
                    <datalist id="datalistOptions">
                       
                    </datalist>
                    <div class="list-attr">
                        
                    </div>
                </div>
                {{-- <div class="mb-3">
                    <label for="lstThuocTinh" class="form-label">Các Biến thể</label>
                    <input class="form-control" list="datalistOptions" id="lstThuocTinh" placeholder="Chọn thuộc tính" >
                    <datalist id="datalistOptions">
                       
                    </datalist>
                    <div class="list-attr">
                        
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-primary">Thêm</button>
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
        $(function() {
                
            $.ajax({
                type: "get",
                url: "/admin/thuoctinhdata/lay-danh-sach-thuoc-tinh",
                dataType: "json",
                success: function (response) {
                    $('#datalistOptions').html(response);
                }
            });
        });

        // === Attribute Option  === // 
        let lstThuocTinh = document.querySelector("#lstThuocTinh");

        lstThuocTinh.addEventListener('change', function(e) {
            $.ajax({
                type: "get",
                url: "/admin/thuoctinhdata/them-thuoc-tinh",
                dataType: "json",
                data: {
                    tenThuocTinh: e.target.value
                },
                success: function (response) {
                    $('.list-attr').html(response);
                }
            });
            
            lstThuocTinh.value = '';

        })
        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                var filePath2 = URL.createObjectURL(e.target.files[1]);
                $(".list-preview-image").css('display', 'flex');
                
                $("#imgPreview1").show().attr("src", filePath);
                $("#imgPreview2").show().attr("src", filePath2);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        // === wysiwyg Editor === // 
        tinymce.init({
            selector: '#moTa',
            plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            language: 'vi'
            });
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