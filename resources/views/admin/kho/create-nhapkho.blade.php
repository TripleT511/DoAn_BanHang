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
                <form method="post" action="{{ route('danhmuc.store') }}">
                    @csrf
                    <fieldset>
                <legend>Phiếu kho</legend>
                <div class="mb-3">
                    <label for="defaultSelect" class="form-label">Loại Phiếu</label>
                    <select id="defaultSelect" name="loaiPhieu" class="form-select">
                        <option value="0">Phiếu nhập</option>
                        <option value="1">Phiếu xuất</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mã đơn hàng</label>
                    <input type="text" name="maDonHang" class="form-control" id="basic-default-fullname" placeholder="Nhập Mã đơn hàng" />
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
                      <tr>
                        <td class="name">Tên sản phẩm ghi ở đây</td>
                        <td>Mã SKU</td>
                        <td>Cái</td>
                        <td><input type="text" name="soLuongSP" class="form-control" id="basic-default-fullname" placeholder="Nhập số lượng" /></td>
                        <td><input type="text" name="soLuongSP" class="form-control" id="basic-default-fullname" placeholder="Nhập giá" /></td>
                        <td>1.000.000đ</td>
                        <td>
                          <a class="btn btn-danger" href="javascript:void(0);"
                                >Xoá</a
                              >
                        </td>
                      </tr>
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
    </style>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        let lstRemoveProduct = document.querySelectorAll(".table-product tr");
       

            // //Search DiaDanh
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

                        let lstItem = document.querySelectorAll(".product-search-item");
                        lstItem.forEach(item => item.addEventListener('click', function() {
                            $("#searchSanPhamKho").val('');

                            const lstClassName = item.classList;
                            const tableProduct = document.querySelector(".table-product");
                            let lstRemoveProduct = document.querySelectorAll(".table-product tr");

                            const nameProduct = item.querySelector(".product-name").innerText;
                            const priceProduct = item.querySelector(".product-price span").innerText;
                            const tdItem = document.createElement("tr");
                            tdItem.classList.add(`${lstClassName[1]}`);
                            const isProduct = document.querySelector(`.table-product tr.${lstClassName[1]}`);

                            if(!(isProduct != undefined)) {
                                tdItem.innerHTML = `<td>${nameProduct}</td>
                                                    <td>1234</td>
                                                    <td>Cái</td>
                                                    <td><input type="text" name="soLuongSP" class="form-control" id="count-pd" placeholder="Nhập số lượng" value="1"/></td>
                                                    <td><input type="text" name="soLuongSP" class="form-control" id="price-pd" placeholder="Nhập giá" value="${priceProduct}"/></td>
                                                    <td id="total"><span>${priceProduct}</span> đ</td>
                                                    <td>
                                                    <a class="btn btn-danger" href="javascript:void(0);">
                                                        Xoá
                                                    </a>
                                                </td>`;
                                tableProduct.appendChild(tdItem);
                            } else {
                                let countPd = isProduct.querySelector("#count-pd");
                                let pricePd = isProduct.querySelector("#price-pd");
                                let total = isProduct.querySelector("#total span");
                                
                                countPd.value = parseInt(countPd.value) + 1;
                                total.innerText = parseFloat(pricePd.value) * parseInt(countPd.value);
                            }
                            
                            $(".list-product-search").css("display", "none");

                        }));
                    }
                });
                }
                
            });
        });


</script>

@endsection