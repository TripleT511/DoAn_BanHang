@extends('layouts.admin')

@section('title','Thêm Mã giảm giá')
@section('css')
<link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css' />
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
    <h4 class="fw-bold py-3">Thêm Mã Giảm Giá</h4>
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
                <form method="post" action="{{ route('discount.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="code">Mã giảm giá</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code" name="code" placeholder="Mã giảm giá" aria-label="Mã giảm giá" aria-describedby="random-code">
                        <button class="btn btn-outline-secondary" type="button" id="random-code">Tạo mã tự động</button>
                      </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="tenMa">Tên mã giảm giá</label>
                    <input type="text" name="tenMa" id="tenMa" class="form-control" placeholder="Nhập tên mã giảm giá" />
                </div>
                <div class="mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input class="form-control" type="file" id="hinhAnh" name="hinhAnh">
                </div>
                <div class="mb-3">
                    <div class="list-preview-image">
                        <div class="preview-image-item">
                            <img src="" alt="imgPreview" id="imgPreview">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="moTa">Mô tả mã giảm giá</label>
                    <textarea name="moTa" id="moTa" class="form-control moTa">
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="soLuong">Số lần sử dụng mã giảm giá</label>
                    <input type="number" name="soLuong" id="soLuong" class="form-control" placeholder="Nhập số lần sử dụng" />
                </div>
                <div class="mb-3">
                    <label for="loaiKhuyenMai" class="form-label">Hình thức khuyến mãi</label>
                    <select id="loaiKhuyenMai" name="loaiKhuyenMai" class="form-select">
                        <option value="0">VND</option>
                        <option value="1">%</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="giaTriKhuyenMai">Giá trị khuyến mãi</label>
                    <input type="text" name="giaTriKhuyenMai" id="giaTriKhuyenMai" class="form-control" placeholder="Nhập giá trị khuyến mãi" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mucGiamToiDa">Mức giảm tối đa</label>
                    <input type="number" name="mucGiamToiDa" id="mucGiamToiDa" class="form-control" placeholder="Không giới hạn nếu để trống" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ngayBatDau">Bắt đầu khuyến mãi</label>
                    <input class="form-control" name="ngayBatDau" type="date" id="ngayBatDau">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ngayKetThuc">Kết thúc khuyến mãi</label>
                    <input class="form-control" name="ngayKetThuc" type="date" id="ngayKetThuc">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="giaTriToiThieu">Giá trị tối thiểu</label>
                    <input type="number" name="giaTriToiThieu" id="giaTriToiThieu" class="form-control" placeholder="Không giới hạn nếu để trống" />
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
                <button type="button" class="btn btn-dark"onclick="history.back()">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection
@section('js')
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.12/js/languages/vi.min.js"></script>
   
    <script>
        // === Random Code Generator === //
        let btnRandom = document.querySelector('#random-code');
        let txtCode = document.querySelector('#code');
        const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        function generateString(length) {
            let result = ' ';
            const charactersLength = characters.length;
            for ( let i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            return result;
        }

        btnRandom.addEventListener( 'click', function() {
            let newString = generateString(10);
            txtCode.value = newString;
        });

        // === Random Code Generator === //


        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".list-preview-image").css('display', 'flex');
                
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        $(function() {
            var editor = new FroalaEditor('#moTa',{
                language: 'vi'
            });
        
        })
        
    </script>
    
@endsection