@extends('layouts.admin')

@section('title','Chỉnh sửa Sản Phẩm')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sản Phẩm/</span> Sửa Sản phẩm</h4>
    <!-- Basic Layout -->
    <div class="row">
        
        <div class="col-xl">
            <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            </div>
            <div class="card-body">
                <form>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Sản Phẩm</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập tên sản phẩm..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mô Tả</label>
                    <input type="text" name="maViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập mô tả..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Đặc trưng</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập đặc trưng sản phẩm... " />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Chất Liệu</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập tên chất liệu..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Màu Sắc</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập tên màu sắc..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Số Lượng</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Số lượng..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Giá</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Giá..." />
                </div>
                <div class="md-3">
                        <label for="formFile" class="form-label">Hình Ảnh</label>
                         <input class="form-control" type="file" id="formFile" name="hinh">
                </div>
                <button type="submit" class="btn btn-primary">Sửa</button>
                <button type="submit" class="btn btn-primary">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection