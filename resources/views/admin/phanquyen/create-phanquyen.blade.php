@extends('layouts.admin')

@section('title','Thêm quyền')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Phân quyền/</span> Thêm quyền</h4>
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
                <form method="post" action="{{ route('phanquyen.store') }}" >
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Tên vị trí</label>
                    <input type="text" name="tenViTri" class="form-control" id="basic-default-fullname" placeholder="Nhập tên vị trí" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Mã vị trí</label>
                    <input type="text" name="viTri" class="form-control" id="basic-default-fullname" placeholder="Nhập một số nào đó..." />
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