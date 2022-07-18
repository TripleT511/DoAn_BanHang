@extends('layouts.admin')

@section('title','Thêm Nhà Cung Cấp')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Thêm Nhà Cung Cấp</h4>
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
                <form method="post" action="{{ route('nhacungcap.store') }}" >
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên Nhà Cung cấp</label>
                    <input type="text" name="tenNhaCungCap" class="form-control" id="basic-default-fullname" placeholder="Nhập tên nhà cung cấp..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">số điện thoại</label>
                    <input type="text" name="soDienThoai" class="form-control" id="basic-default-fullname" placeholder="Nhập số điện thoại..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Email</label>
                    <input type="text" name="email" class="form-control" id="basic-default-fullname" placeholder="Nhập Email..." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Địa chỉ</label>
                    <input type="text" name="diaChi" class="form-control" id="basic-default-fullname" placeholder="Nhập Địa chỉ ..." />
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-dark" onclick="history.back()">Thoát</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection
