@extends('layouts.admin')

@section('title','Sửa Mã giảm giá')
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
    <h4 class="fw-bold py-3">Sửa Mã Giảm Giá</h4>
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
                <form method="post" action="{{ route('discount.update', ['discount' => $maGiamGia]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="code">Mã giảm giá</label>
                    <input type="text" value="{{ $maGiamGia->code }}" name="tenMa" id="tenMa" class="form-control text-dark"  disabled/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="tenMa">Tên mã giảm giá</label>
                    <input type="text" value="{{ $maGiamGia->tenMa }}" name="tenMa" id="tenMa" class="form-control" placeholder="Nhập tên mã giảm giá" />
                </div>
                <div class="mb-3">
                    <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                    <input class="form-control" type="file" id="hinhAnh" name="hinhAnh">
                </div>
                <div class="mb-3">
                    <div class="list-preview-image">
                        <div class="preview-image-item">
                            <img src="{{ asset('storage/'.$maGiamGia->hinhAnh) }}" alt="imgPreview" id="imgPreview">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="moTa">Mô tả mã giảm giá</label>
                    <textarea name="moTa" id="moTa" class="form-control moTa">
                        {!! $maGiamGia->moTa !!}
                    </textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="soLuong">Số lần sử dụng mã giảm giá</label>
                    <input type="number" value="{{ $maGiamGia->soLuong }}" name="soLuong" id="soLuong" class="form-control" placeholder="Nhập số lần sử dụng (Không giới hạn nếu bỏ trống)" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mucGiamToiDa">Mức giảm tối đa</label>
                    <input type="number" value="{{ $maGiamGia->mucGiamToiDa }}" name="mucGiamToiDa" id="mucGiamToiDa" class="form-control" placeholder="Không giới hạn nếu để trống" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ngayBatDau">Bắt đầu khuyến mãi</label>
                    <input class="form-control" value="{{ date('Y-m-d',strtotime($maGiamGia->ngayBatDau)) }}" name="ngayBatDau" type="date" id="ngayBatDau" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="ngayKetThuc">Kết thúc khuyến mãi</label>
                    <input class="form-control" value="{{ date('Y-m-d',strtotime($maGiamGia->ngayKetThuc)) }}" name="ngayKetThuc" type="date" id="ngayKetThuc">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="giaTriToiThieu">Giá trị tối thiểu</label>
                    <input type="number" value="{{ $maGiamGia->giaTriToiThieu }}" name="giaTriToiThieu" id="giaTriToiThieu" class="form-control" placeholder="Không giới hạn nếu để trống" />
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
                <button type="button" class="btn btn-dark"onclick="history.back()">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection
@section('js')
    <script>


        // === Preview Image === // 
       
        $("#hinhAnh").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".list-preview-image").css('display', 'flex');
                
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        // === CK Editor === // 
        tinymce.init({
            selector: '#moTa',
            plugins: 'a11ychecker advcode casechange export formatpainter image  editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table insertfile tableofcontents undo redo link',
            image_title: true,
            automatic_uploads: true,
            file_picker_callback: function (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                let type = 'image' === meta.filetype ? 'Images' : 'Files',
                    url  = '/laravel-filemanager?editor=tinymce5&type=' + type;

                tinymce.activeEditor.windowManager.openUrl({
                    url : url,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            },
            toolbar_mode: 'floating',
            language: 'vi'
        });
        
    </script>
    
@endsection