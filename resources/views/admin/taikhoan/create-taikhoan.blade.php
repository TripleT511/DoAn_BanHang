@extends('layouts.admin')

@section('title','Thêm tài khoản')
@section('css')
    <style>
        .list-preview-image {
            display: none;
            align-content: center;
            gap: 10px;
        }
        .preview-image-item {
            width: 100px;
            height: 100px;
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tài khoản/</span> Thêm tài khoản nhân viên</h4>
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
                <form method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
                    @csrf
                <div class="mb-3">
                    <label class="form-label" for="hoTen">Họ tên</label>
                    <input type="text" name="hoTen" class="form-control" id="hoTen" placeholder="Nhập họ tên..." />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="basic-default-phone">Số điện thoại</label>
                    <input
                    type="text"
                    name ="soDienThoai"
                    id="basic-default-phone"
                    class="form-control phone-mask"
                    placeholder="Nhập số điện thoại..."
                    />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="basic-default-email">Email</label>
                    <div class="input-group input-group-merge">
                    <input
                        type="text"
                        name="email"
                        id="basic-default-email"
                        class="form-control"
                        placeholder="Nhập email..."
                        aria-label="Nhập email..."
                        aria-describedby="basic-default-email2"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                    </div>
                    <div class="form-text">Bạn có thể sử dụng chữ cái, số & dấu chấm</div>
                </div>
          
                <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder=".........."
                    aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

                <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Phân quyền</label>
                        <select id="defaultSelect" name="phan_quyen_id" class="form-select">
                        <option>Chọn quyền</option>
                        @foreach($lstPhanQuyen as $pq)
                        <option value="{{$pq->viTri}}">{{$pq->tenViTri}}</option>
                        @endforeach
                    </select>
                    </div>

                <div class="mb-3">
                    <label for="anhDaiDien" class="form-label">Ảnh đại diện</label>
                    <input class="form-control" type="file"name="anhDaiDien" id="anhDaiDien">
                </div>

                <div class="mb-3">
                    <div class="list-preview-image">
                        <div class="preview-image-item">
                            <img src="" alt="imgPreview" id="imgPreview">
                        </div>
                    </div>
                 
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
@section('js')
    <script src="https://cdn.tiny.cloud/1/c4yq515bjllc9t8mkucpjw8rmw5jnuktk654ihvvk2k4ve5f/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>

        // === Preview Image === // 
       
        $("#anhDaiDien").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".list-preview-image").css('display', 'flex');
                
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        // === wysiwyg Editor === // 
        
    </script>
@endsection