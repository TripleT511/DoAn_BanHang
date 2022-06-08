@extends('layouts.admin')

@section('title','Thêm Phiếu Kho')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Phiếu Nhập Kho/</span> Thêm Phiếu</h4>
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
                <form method="post" action="{{ route('phieukho.store') }}">
                    @csrf
                    <fieldset>
                <legend>Phiếu kho</legend>
                <div class="mb-3">
                    <label for="loaiPhieu" class="form-label">Loại Phiếu</label>
                    <select id="loaiPhieu" name="loaiPhieu" class="form-select">
                        <option value="0">Phiếu nhập</option>
                        <option value="1">Phiếu xuất</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="maDonHang">Mã đơn hàng</label>
                    <input type="text" name="maDonHang" class="form-control" id="maDonHang" placeholder="Nhập Mã đơn hàng" />
                </div>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Nhà Cung Cấp</label>
                    <select id="defaultSelect" name="nhacungcapid" class="form-select">
                        <option value="0">Chọn Nhà Cung Cấp</option>
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
                <div class="mb-3 input-search-custom">
                    <div class="input-group input-group-merge ">
                    <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-search'></i></span>
                    <input type="text" id="searchSanPhamKho" class="form-control" placeholder="Tìm sản phẩm..." aria-label="Tìm sản phẩm..." aria-describedby="basic-icon-default-company2">
                    </div>
                    <ul class="list-product-search">
                    </ul>
                </div>
                
                <div class="mb-3">
                    <div class="table-responsive text-nowrap">
                  <table class="table text-left">
                    <thead>
                      <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>SKU</th>
                        <th>Đơn vị tính</th>
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
                   
                <input type="text" name="loaiPhieu" value="1" hidden/>
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
@endsection
@section('css')
    <style>
        .input-search-custom {
            position: relative;
        }

        .list-product-search {
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

        .product-search-item .product-name {
            margin-bottom: 5px;
            color: #697A8D;
        }

        .product-search-item .product-price {
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
    </style>
@endsection
@section('js')
<script>
    $(function() {
      let lstRemoveProduct = document.querySelectorAll(".table-product tr");
        let lstSP = document.querySelectorAll(".product-search-item");
        let lstBtnDelete = document.querySelectorAll(".btn-xoa");
        let lstBtnUpdate = document.querySelectorAll(".btn-update");

            
            //Search DiaDanh
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
                                    }
                                });
                        }));

                        // Cập nhật chi tiết phiếu kho
                        lstBtnUpdate.forEach((item, index) => item.addEventListener('click', function () {
                            if(lstSoLuong[index].value <= 0 || isNaN(lstSoLuong[index].value) || isNaN(lstGia[index].value) || lstGia[index].value <= 0) {
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
                                        document.querySelector(".bs-toast").classList.remove("bg-danger");
                                        document.querySelector(".bs-toast").classList.add("bg-success");
                                        document.querySelector(".toast-body").innerText = "Cập nhật thành công";

                                        document.querySelector(".bs-toast").classList.add("show");
                                        setTimeout(() => {
                                            document.querySelector(".bs-toast").classList.remove("show");
                                        }, 2000);
                                       renderUI();
                                    }
                                });
                            }
                                
                        }))
                    }
                });
            }  
    });


</script>

@endsection