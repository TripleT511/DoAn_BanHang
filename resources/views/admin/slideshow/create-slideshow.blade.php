@extends('layouts.admin')

@section('title','Thêm SlideShow')

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
                <form>
                <div class="md-3">
                        <label for="formFile" class="form-label">Hình Ảnh</label>
                         <input class="form-control" type="file" id="formFile" name="hinh">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Nội Dung</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Nội dung SlideShow" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tiêu Đề</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Tiêu Đề SlideShow" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Slug</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập Slug" />
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