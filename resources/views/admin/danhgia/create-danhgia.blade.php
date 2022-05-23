@extends('layouts.admin')

@section('title','Thêm Loại Sản Phẩm')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Loại Sản Phẩm/</span> Thêm Loại Sản Phẩm</h4>
    <!-- Basic Layout -->
    <div class="row">
        
        <div class="col-xl">
            <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            </div>
            <div class="card-body">
                <form>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">sanpham_id</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập id Sản Phẩm" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">taikhoan_id</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập id Tài Khoản" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Email</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Email" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Ho Tên</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Họ Tên" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Nội dung</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Nôi dung" />
                </div>                
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Xếp Hạng</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Xếp Hạng" />
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="submit" class="btn btn-primary">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection