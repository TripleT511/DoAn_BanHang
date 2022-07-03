@extends('layouts.admin')

@section('title','Chỉnh sửa tài khoản')
@section('css')
    <style>
        .list-preview-image {
            display: flex;
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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tài Khoản/</span>Đổi mật khẩu</h4>
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
                <form method="post" action="{{ route('doimatkhau',['user' => $user]) }}" enctype="multipart/form-data">
                    @csrf
                    @method("POST")                 
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                          <label class="form-label" for="password">Mật khẩu mới</label>
                        </div>
                        <div class="input-group input-group-merge">
                          <input type="password" id="password" class="form-control" name="password"
                            placeholder="Mật khẩu mới.........."
                            aria-describedby="password" />
                          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                      </div>
                       <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                          <label for="password" class="form-label">Xác nhận mật khẩu mới</label>
                        </div>
                        <div class="input-group input-group-merge">
                          <input type="password" id="newpassword" class="form-control" name="newpassword"
                            placeholder="Nhập lại mật khẩu........"
                            aria-describedby="password" />
                          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                      </div>
                <button type="submit" class="btn btn-primary">Đổi</button>
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
                $(".preview-image-item").css('display', 'flex');
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        // === wysiwyg Editor === // 
        
    </script>
@endsection