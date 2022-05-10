@extends('layouts.admin')

@section('title','Chỉnh sửa Loại Sản Phẩm')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Loại Sản Phẩm/</span> Sửa Loại Sản Phẩm</h4>
    <!-- Basic Layout -->
    <div class="row">
        
        <div class="col-xl">
            <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            </div>
            <div class="card-body">
                <form>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Loại Sản Phẩm</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập tên vị trí" />
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