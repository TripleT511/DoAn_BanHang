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
        
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Thêm Sản Phẩm</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <form method="post" action="{{ route('sanpham.store') }}" enctype="multipart/form-data">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    </div>
                    <div class="card-body">
                        @if($errors->any()) 
                            @foreach ($errors->all() as $err)
                                <li class="card-description" style="color: #fc424a;">{{ $err }}</li>
                            @endforeach
                        @endif
                            @method('POST')
                            @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Tên Sản Phẩm</label>
                            <input type="text" name="tenSanPham" class="form-control" id="basic-default-fullname" placeholder="Nhập tên sản phẩm..." />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Mã sản phẩm</label>
                            <input type="text" name="maSKU" class="form-control" id="basic-default-fullname" placeholder="Nhập mã sản phẩm (SKU)" />
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
                                <option value="1">Sản phẩm bán chạy</option>
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
                            <label for="danhmucid" class="form-label">Danh mục sản phẩm</label>
                            <select id="danhmucid" name="danhmucid" class="form-select">
                                <option value="">Chọn danh mục sản phẩm</option>
                                @foreach($lstDanhMuc as $dm)
                                <option value="{{$dm->id}}">{{$dm->tenDanhMuc}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mausac" class="form-label">Màu sắc</label>
                            <select id="mausac" name="mausac" class="form-select">
                                <option value="">Chọn màu sắc</option>
                                @foreach($lstMauSac as $color)
                                <option value="{{$color->id}}">{{$color->tieuDe}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                            <input class="form-control" type="file" id="hinhAnh" name="hinhAnh[]" multiple>
                        </div>
                        <div class="mb-3">
                            <div class="list-preview-image">
                               
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                                        Size
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                                        Biến thể
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                                        <div class="lstOptionValue">

                                        </div>
                                        <div class="mb-3">
                                                <div class="attr-item align-items-center d-flex">
                                                    <div class="tag-input">
                                                        <select id="valueOptions"  class="form-select form-select-size">
                                                            <option value="">Chọn size</option>
                                                            @foreach($lstSize as $size)
                                                                <option value="{{$size->id}}">{{$size->tieuDe}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table text-left">
                                                    <thead>
                                                    <tr>
                                                        <th>Tên biến thể</th>
                                                        <th>Mã SKU</th>
                                                        <th>Giá</th>
                                                        <th>Giá khuyến mãi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0 text-left table-product" id="tableVariants">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div>
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-dark" onclick="history.back()">Thoát</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
            $(".list-preview-image").css('display', 'flex');
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

        // === Attribute Option  === //
       let lstOption = document.querySelectorAll("#option");
       let arrayOptionsLabel = [];

        let lstSelect = document.querySelectorAll(".form-select-size");

        lstSelect.forEach(item => item.addEventListener('change', function (e) {
            console.log(e);

            let issetTag = document.querySelector(`.tag-item-${e.target.value}`);
            if(issetTag) {
                item.value = "";
                return;
            }
            var tag = document.createElement("span");
            var tagClose = document.createElement("i");
            tagClose.classList.add("bx", "bx-x", "btn-del-value");
            tagClose.setAttribute('data-valueid', e.target.value);
            
            tag.classList.add("tag-item","bg-primary",`tag-item-${e.target.value}`,`tag-option-${item.dataset.id}`);
            var text = document.createTextNode($(`#valueOptions option:selected`).text());
            tag.appendChild(text);
            tag.appendChild(tagClose);

            
            $(tag).insertBefore(`#valueOptions`);
            var optionValue = document.createElement("input");
            optionValue.setAttribute("type", "hidden");
            optionValue.setAttribute("name", "giaTriThuocTinh[]");
            optionValue.setAttribute("id", `giaTriThuocTinh-${e.target.value}`);
            optionValue.setAttribute("value", e.target.value);
            document.querySelector(".lstOptionValue").appendChild(optionValue);
          

            // Thêm biến thể
            let table = document.querySelector("#tableVariants");
            let trTag = document.createElement("tr");
            trTag.setAttribute("id", `variant-item-${e.target.value}`);
            let nameBienThe = $(`#valueOptions option:selected`).text()
            trTag.innerHTML = `
                <td>${nameBienThe}</td>
                <td><input type="text" name="variant_sku[]" value="" class="form-control input-sl" placeholder="Nhập mã sản phẩm"></td>
                <td><input type="number" name="variant_price[]" value="0" class="form-control input-sl" placeholder="Nhập giá"></td>
                <td><input type="number" name="variant_price_sale[]" value="0" class="form-control input-gia" placeholder="Nhập giá khuyến mãi">
                </td>
            `;

            table.appendChild(trTag);

            //
            removeOptionValue();
            item.value = "";
        }));

        function removeOptionValue() {
            // Remove Value Option
            let lstBtnDelValue = document.querySelectorAll(".btn-del-value");
            lstBtnDelValue.forEach(item => item.addEventListener("click", function(e) {
                    const valueOptionItem = document.querySelector(`.tag-item-${item.dataset.valueid}`);
                    const inputValue = document.querySelector(`#giaTriThuocTinh-${item.dataset.valueid}`);
                    const variantItem = document.querySelector(`#variant-item-${item.dataset.valueid}`);
                    if(valueOptionItem && inputValue) {
                        valueOptionItem.remove();
                        inputValue.remove();
                        variantItem.remove();
                    }
            }));
        }
       
    </script>
@endsection