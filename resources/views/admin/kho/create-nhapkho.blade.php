@extends('layouts.admin')

@section('title','Thêm Phiếu Kho')
@section('css')
<style>

        .input-search-custom {
            position: relative;
        }
        .list-product-search,
        .list-product-search-2 {
            display: none;
            position: absolute;
            content: "";
            width: 100%;
            top: 50px;
            background: #fff;
            border: 1px solid #d9dee3;
            border-radius: 0.375rem;
            padding: 0;
            list-style: none;
            scroll-snap-type: y mandatory;
            max-height: 185px;
            overflow: auto;
        }
        .product-search-item {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            cursor: pointer;
        }

        .product-search-item p {
            margin: 0;
        }

        .product-search-item .product-description {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        .product-search-item .product-name {
            margin-bottom: 5px;
            color: #697A8D;
            font-weight: bold;
        }

        .product-search-item .product-sku {
            margin-right: 10px;
        }

        .product-search-item .product-price span {
            margin: 0;
            color: #fc424a;
        }
        .product-search-img {
            width: 50px;
            height: 75px;
            position: relative;
            padding: 5px;
            margin-right: 10px;
        }
        .product-search-img img {
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
    <h4 class="fw-bold mb-4"> Thêm Phiếu Nhập Kho</h4>
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
                <form method="post" id="themPhieuKho" action="{{ route('phieukho.store') }}">
                    @csrf
                    <fieldset>
                <div class="mb-3">
                    <label class="form-label" for="maDonHang">Mã đơn hàng</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="maDonHang" name="maDonHang" placeholder="Mã đơn hàng"  aria-describedby="random-maDonHang">
                        <button class="btn btn-outline-secondary" type="button" id="random-maDonHang">Tạo mã tự động</button>
                      </div>
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Nhà Cung Cấp</label>
                    <select id="defaultSelect" name="nhacungcapid" class="form-select">
                        <option value="">Chọn Nhà Cung Cấp</option>
                        @foreach($lstNCC as $ncc)
                        <option value="{{$ncc->id}}">{{$ncc->tenNhaCungCap}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Ghi Chú</label>
                    <textarea class="form-control" id="ghiCHu" name="ghiChu" rows="3"></textarea>
                </div>
                
                    </fieldset>
                <legend>Chi tiết phiếu kho</legend>
                <div class="row">
                    <div class="col-md-9">
                        <div class="mb-3 input-search-custom">
                            <div class="input-group input-group-merge ">
                            <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-search'></i></span>
                            <input type="text" id="searchSanPhamKho" class="form-control" placeholder="Tìm sản phẩm..." aria-label="Tìm sản phẩm..." aria-describedby="basic-icon-default-company2">
                            </div>
                            <ul class="list-product-search">
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <a class="btn btn-outline-success btn-create-product" data-bs-toggle="modal" data-bs-target="#modalCenter"  href="#">
                                <i class='bx bx-plus-circle'></i> Thêm sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="table-responsive text-nowrap">
                  <table class="table text-left">
                    <thead>
                      <tr>
                        <th>Mã hàng</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                        <th>Hành Động</th>              
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 text-left table-product">
                      
                    </tbody>
                  </table>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="submit" class="btn btn-primary">Cancel</button>
                </form>
            </div>
            </div>
        </div>
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-50 start-50 translate-middle " role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Thông báo</div>
                <small>1 second ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">Lỗi</div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalCenter" tabindex="-1"  aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Thêm sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
            <div class="mb-3 input-search-custom">
                <div class="input-group input-group-merge ">
                <span id="icon-search2" class="input-group-text"><i class='bx bx-search'></i></span>
                <input type="text" id="searchSanPham" class="form-control" placeholder="Tìm sản phẩm..." aria-label="Tìm sản phẩm..." aria-describedby="icon-search2">
                </div>
                <ul class="list-product-search-2">
                </ul>
            </div>
            <form method="post" action="javascript:void(0)" id="formProDuct" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="mb-3">
                    <label class="form-label" for="tenSanPham">Tên Sản Phẩm</label>
                    <input type="text" name="tenSanPham" class="form-control" id="tenSanPham" placeholder="Nhập tên sản phẩm..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sku">Mã sản phẩm</label>
                    <input type="text" name="sku" class="form-control" id="sku" placeholder="Nhập mã sản phẩm (SKU)" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="moTa">Mô Tả</label>
                    <textarea name="moTa" id="moTa" class="form-control moTa">
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="noiDung">Nội dung</label>
                    <textarea name="noiDung" id="noiDung" class="form-control noidung-sp">
                    </textarea>
                </div>
                <div class="mb-3">
                    <label for="dacTrung" class="form-label">Đặc trưng</label>
                    <select id="dacTrung" name="dacTrung" class="form-select">
                        <option value="0">Chọn đặc trưng</option>
                        <option value="1">Sản phẩm bán chạy</option>
                        <option value="2">Sản phẩm hot</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="gia">Giá</label>
                    <input type="text" name="gia" class="form-control" id="gia" placeholder="Nhập giá..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="giaKhuyenMai">Giá khuyến mãi</label>
                    <input type="text" name="giaKhuyenMai" class="form-control" id="giaKhuyenMai" placeholder="Nhập giá khuyến mãi ..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Nhập slug ..." />
                </div>
                <div class="mb-3">
                    <label for="danhmucid" class="form-label">Danh mục sản phẩm</label>
                    <select id="danhmucid" name="danhmucid" class="form-select">
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
                        <div class="preview-image-item" id="preview1">
                            <img src="" alt="imgPreview" id="imgPreview1">
                        </div>
                        <div class="preview-image-item" id="preview2">
                            <img src="" alt="imgPreview"
                            id="imgPreview2">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-add-san-pham">Thêm sản phẩm</button>
                <button type="reset" class="btn btn-outline-primary btn-reset">Reset</button>
               
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" id="closeModel" class="btn btn-outline-primary" data-bs-dismiss="modal">
            Đóng
        </button>
        </div>
    </div>
    </div>
</div>
<div class="modal-backdrop fade "></div>
@endsection

@section('js')

<script>
    $(function() {
      let lstRemoveProduct = document.querySelectorAll(".table-product tr");
        let lstSP = document.querySelectorAll(".product-search-item");
        let lstBtnDelete = document.querySelectorAll(".btn-xoa");
        let lstBtnUpdate = document.querySelectorAll(".btn-update");
        let modelBtn = document.querySelector(".btn-create-product");

        // === Random maDonHang Generator === //
        let btnRandom = document.querySelector('#random-maDonHang');
        let txtmaDonHang = document.querySelector('#maDonHang');
        const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        function generateString(length) {
            let result = ' ';
            const charactersLength = characters.length;
            for ( let i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }

        btnRandom.addEventListener( 'click', function() {
            let newString = generateString(30);
            txtmaDonHang.value = newString;
        });

        // === Random maDonHang Generator === //
        

        // === Thêm sản phẩm === //
      
        modelBtn.addEventListener('click', function() {
        let formAdd = document.querySelector("#formProDuct");
            formAdd.addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    type: "POST",
                    url: "/admin/kho/them-san-pham",
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function (response) {
                        if(response.error) {

                            document.querySelector(".bs-toast").classList.add("bg-danger");
                            document.querySelector(".bs-toast").classList.remove("bg-success");
                            document.querySelector(".toast-body").innerHTML = response.error;
                            document.querySelector(".bs-toast").classList.add("show");
                            setTimeout(() => {
                                document.querySelector(".bs-toast").classList.remove("show");
                            }, 1000);

                            return;
                        } else {
                            $("#hinhAnh").val('');
                            $(".list-preview-image").css('display', 'none');

                            let btnShowModel = document.querySelector("#closeModel");
                            btnShowModel.click();

                            document.querySelector(".bs-toast").classList.add("bg-success");
                            document.querySelector(".bs-toast").classList.remove("bg-danger");
                            document.querySelector(".toast-body").innerHTML = response.success;
                            document.querySelector(".bs-toast").classList.add("show");
                            setTimeout(() => {
                                document.querySelector(".bs-toast").classList.remove("show");
                            }, 1000);
                            renderUI();
                            return ;
                        }
                    }
                });
                
        });
        })
        
        

        // === Thêm sản phẩm === //



        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
            $(".list-preview-image").css('display', 'flex');
                var filePath = URL.createObjectURL(e.target.files[0]);
                $("#imgPreview1").show().attr("src", filePath);
                if(e.target.files[1]) {
                     $("#preview2").show();
                    var filePath2 = URL.createObjectURL(e.target.files[1]);
                    $("#imgPreview2").show().attr("src", filePath2);
                } else {
                    $("#preview2").hide();
                }
                
              
               
            });

        // === Preview Image === //     

            //Search Sản Phẩm 1
            $('#searchSanPhamKho').on('keyup', function() {
                var val = $('#searchSanPhamKho').val();
                if(val != "") {
                    $.ajax({
                    type: "get",
                    url: "/admin/kho/timkiem",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $(".list-product-search").css("display", "block");
                        $(".list-product-search").html(response);
                        
                        lstSP = document.querySelectorAll(".product-search-item");

                        lstSP.forEach(item => item.addEventListener('click', function () {
                            
                            $(".list-product-search").css("display", "none");
                                $.ajax({
                                    type: "get",
                                    url: "/admin/kho/them-chi-tiet",
                                    dataType: "json",
                                    data: {
                                        sanpham: item.dataset.id
                                    },
                                    success: function (response) {
                                        renderUI();
                                        return ;
                                    }
                                });
                        }));
                        
                    }
                });
                }
                
            });

           //Search Sản Phẩm 2
            $('#searchSanPham').on('keyup', function() {
                var val = $('#searchSanPham').val();
                if(val != "") {
                    $.ajax({
                    type: "get",
                    url: "/admin/kho/timkiem",
                    data: {
                        txtSearch: val
                    },
                    dataType: "json",
                    success: function (response) {
                        $(".list-product-search-2").css("display", "block");
                        $(".list-product-search-2").html(response);
                        
                        lstSP = document.querySelectorAll(".list-product-search-2 .product-search-item");

                        lstSP.forEach(item => item.addEventListener('click', function () {
                            
                            $(".list-product-search-2").css("display", "none");
                                $.ajax({
                                    type: "get",
                                    url: "/admin/kho/chon",
                                    dataType: "json",
                                    data: {
                                        sanpham: item.dataset.id
                                    },
                                    success: function (response) {
                                       console.log(response);
                                       $("#tenSanPham").val(response.tenSanPham);
                                       $("#sku").val(response.sku);
                                       tinyMCE.get('moTa').setContent(response.moTa);
                                       tinyMCE.get('noiDung').setContent(response.noiDung);
                                       $("#gia").val(response.gia);
                                     
                                    }
                                });
                        }));
                        
                    }
                });
                }
                
            });
          

            function renderUI() {
                $("#searchSanPhamKho").val('');
                $.ajax({
                    type: "get",
                    url: "/admin/kho/xem-chi-tiet",
                    dataType: "json",
                    success: function (response) {
                        $(".table-product").html(response);
                        lstBtnDelete = document.querySelectorAll(".btn-xoa");
                        lstBtnUpdate = document.querySelectorAll(".btn-update");
                        let lstSoLuong = document.querySelectorAll(".input-sl");
                        let lstGia = document.querySelectorAll(".input-gia");

                         // Xoá chi tiết phiếu kho
                        lstBtnDelete.forEach(item => item.addEventListener('click', function () {
                                $.ajax({
                                    type: "get",
                                    url: "/admin/kho/xoa-chi-tiet",
                                    dataType: "json",
                                    data: {
                                        id: item.dataset.id
                                    },
                                    success: function (response) {
                                       renderUI();
                                       return ;
                                    }
                                });
                        }));

                        // Cập nhật chi tiết phiếu kho
                        lstBtnUpdate.forEach((item, index) => item.addEventListener('click', function () {
                            if(lstSoLuong[index].value <= 0 || isNaN(lstSoLuong[index].value) || isNaN(lstGia[index].value) || lstGia[index].value < 0) {
                                document.querySelector(".bs-toast").classList.add("bg-danger");
                                document.querySelector(".bs-toast").classList.remove("bg-success");
                                document.querySelector(".toast-body").innerText = "Lỗi";
                                document.querySelector(".bs-toast").classList.add("show");
                                setTimeout(() => {
                                    document.querySelector(".bs-toast").classList.remove("show");
                                }, 2000);
                            } else {
                                $.ajax({
                                    type: "get",
                                    url: "/admin/kho/cap-nhat-chi-tiet",
                                    dataType: "json",
                                    data: {
                                        id: item.dataset.id,
                                        soluong: lstSoLuong[index].value,
                                        gia: lstGia[index].value
                                    },
                                    success: function (response) {
                                        if(response.error) {

                                            document.querySelector(".bs-toast").classList.add("bg-danger");
                                            document.querySelector(".bs-toast").classList.remove("bg-success");
                                            document.querySelector(".toast-body").innerHTML = response.error;
                                            document.querySelector(".bs-toast").classList.add("show");
                                            setTimeout(() => {
                                                document.querySelector(".bs-toast").classList.remove("show");
                                            }, 1000);

                                            return;
                                        }
                                        document.querySelector(".bs-toast").classList.remove("bg-danger");
                                        document.querySelector(".bs-toast").classList.add("bg-success");
                                        document.querySelector(".toast-body").innerText = "Cập nhật thành công";

                                        document.querySelector(".bs-toast").classList.add("show");
                                        setTimeout(() => {
                                            document.querySelector(".bs-toast").classList.remove("show");
                                        }, 2000);
                                       renderUI();
                                       return ;
                                    }
                                });
                            }
                                
                        }))
                    }
                });

            }
            // === CK Editor === // 
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
          
    });


</script>

@endsection