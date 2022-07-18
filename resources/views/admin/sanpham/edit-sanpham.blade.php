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
                        value="{{ $sanpham->sku }}" placeholder="Nhập mã sản phẩm (SKU)" />
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
                        <label for="mausac" class="form-label">Màu sắc</label>
                        <select id="mausac" name="mausac" class="form-select">
                            <option value="">Chọn màu sắc</option>
                            @foreach($lstMauSac as $color)
                            <option value="{{$color->id}}" {{ $color->id == $idMauSac ? "selected" : ''}}>{{$color->tieuDe}}</option>
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
                                            @if($lstBienTheSanPham)
                                                @foreach($lstBienTheSanPham as $item)
                                                    @if($item->tuychonbienthe->sizes)
                                                    <input type="hidden" name="giaTriThuocTinh[]" id="giaTriThuocTinh-{{
                                                        $item->tuychonbienthe->sizes->id
                                                    }}" value="{{
                                                        $item->tuychonbienthe->sizes->id
                                                    }}">
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                                <div class="attr-item align-items-center d-flex">
                                                    <div class="tag-input">
                                                        @if($lstBienTheSanPham)
                                                            @foreach($lstBienTheSanPham as $item)
                                                                @if($item->tuychonbienthe->sizes)
                                                                    <span class="tag-item bg-primary tag-item-{{
                                                        $item->tuychonbienthe->sizes->id
                                                    }} tag-option-undefined">{{
                                                        $item->tuychonbienthe->sizes->tieuDe
                                                    }}<i class="bx bx-x btn-del-value" data-valueid="{{
                                                        $item->tuychonbienthe->sizes->id
                                                    }}"></i></span>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
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
                                                        @if($lstBienTheSanPham)
                                                            @foreach($lstBienTheSanPham as $item)
                                                                @if($item->tuychonbienthe->sizes)
                                                                     <tr id="variant-item-{{ $item->tuychonbienthe->sizes->id }}">
                                                                        <td>{{
                                                        $item->tuychonbienthe->sizes->tieuDe
                                                    }}</td>
                                                                        <td><input type="text" name="variant_sku[]" class="form-control input-sl" value="{{ $item->sku }}"
                                                                             placeholder="Nhập mã sản phẩm"></td>
                                                                        <td><input type="number" name="variant_price[]" value="{{ $item->gia }}" class="form-control input-sl" placeholder="Nhập giá"></td>
                                                                        <td><input type="number" name="variant_price_sale[]" value="{{ $item->giaKhuyenMai }}" class="form-control input-gia" placeholder="Nhập giá khuyến mãi">
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                       
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                            </div>
                        </div>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
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

        function removeOptionValue() {
            // Remove Value Option
            lstBtnDelValue = document.querySelectorAll(".btn-del-value");
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