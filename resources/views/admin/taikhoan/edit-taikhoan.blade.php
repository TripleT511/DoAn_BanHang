@extends('layouts.admin')

@section('title','Chỉnh sửa tài khoản')
@section('css')
    <style>
        .list-preview-image {
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>Chỉnh sửa tài khoản nhân viên</h4>
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
                <form method="post" action="{{ route('user.update',['user' => $user]) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PATCH")
                    <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Họ tên</label>
                    <input type="text" name="hoTen" class="form-control" id="basic-default-fullname" value="{{ $user->hoTen }}" placeholder="John Doe" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="basic-default-phone">Số điện thoại</label>
                    <input
                    type="text"
                    name ="soDienThoai"
                    id="basic-default-phone"
                    class="form-control phone-mask"
                    value="{{ $user->soDienThoai }}"
                    placeholder="037 934 5986"
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
                        value="{{ $user->email }}"
                        placeholder="john.doe"
                        aria-label="john.doe"
                        aria-describedby="basic-default-email2"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                    </div>
                    <div class="form-text">Bạn có thể sử dụng chữ cái, số & dấu chấm</div>
                </div>
          
                <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Phân quyền</label>
                        <select id="defaultSelect" name="phanquyenid" class="form-select">
                        <option value="0">Chọn quyền</option>
                        @foreach($lstPhanQuyen as $pq)
                        <option value="{{$pq->viTri}}" {{ $user->phan_quyen_id == $pq->viTri ? 'selected' : ''}} >{{$pq->tenViTri}}</option>
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
                            <img alt="Avatar" src="{{ asset('storage/'.$user->anhDaiDien) }}" alt="imgPreview" id="imgPreview">
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
       
        $("#hinhAnh").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".preview-image-item").css('display', 'flex');
                
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        // === wysiwyg Editor === // 
        
    </script>
@endsection