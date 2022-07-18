@extends('layouts.admin')

@section('title','Thêm Thuộc Tính')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sửa thuộc tính</h4>
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
                <form method="post" action="{{ route('thuoctinh.update', ['thuoctinh' => $thuoctinh]) }}">
                    @csrf
                    @method("PATCH")
                    <div class="mb-3">
                        <label for="thuocTinh" class="form-label">Tên thuộc tính</label>
                        <select id="thuocTinh" name="tenThuocTinh" class="form-select" disabled>
                            @foreach ($lstThuocTinh as $item)
                                <option value="{{$item->tenThuocTinh}}" {{ ($item->tenThuocTinh == $thuoctinh->tenThuocTinh) ? 'selected' : ''}}>{{ $item->tenThuocTinh }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="loaiThuocTinh" class="form-label">Loại thuộc tính</label>
                        <select id="loaiThuocTinh" name="loaiThuocTinh" class="form-select" disabled>
                            <option value="Text" {{ ($thuoctinh->loaiThuocTinh == "Text" ? "selected" : '')}}>Chữ</option>
                            <option value="Color" {{ ($thuoctinh->loaiThuocTinh == "Color" ? "selected" : '')}}>Màu sắc</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label fclass="form-label">Tuỳ chọn thuộc tính</label>
                        <table class="table">
                        
                        <thead>
                        <tr>
                            <th>Tên đề</th>
                            <th>Giá trị</th>
                            <th>Hành động</th>              
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 lstOption">
                            @foreach($lstTuyChonThuocTinh as $item)
                                <tr class="option-item">
                                    <input type="hidden" name="idOption[]" value="{{ $item->id }}">
                                <td>
                                <input class="form-control" type="text" id="tieuDe" name="tieuDe[]" value="{{ $item->tieuDe }}">
                                </td>
                                <td>
                                <input class="form-control color-picker" type="text" id="mauSac" name="mauSac[]" value="{{ $item->mauSac }}">
                                </td>
                                <td>
                                    <button style="outline: none; border: none" class="btn btn-danger btn-trash" type="button"><i class="bx bx-trash me-1"></i> </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="mb-3">
                        <button type="button" id="themOption" class="btn btn-outline-success d-flex align-items-center" style="gap: 5px"><i class="bx bxs-plus-circle"></i> Thêm </button>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <button type="button" class="btn btn-primary">Cancel</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js" ></script>
    <script>
        $(function() {
            $(".color-picker").each(function() {
                $(this).colorpicker({color: $(this).val()});
            });
        });
     
        let btnThem = document.querySelector("#themOption");
        let lstBtnDelete = document.querySelectorAll(".btn-trash");
        let lstOptionItem = document.querySelectorAll(".option-item");

        lstBtnDelete.forEach((item, index) => item.addEventListener('click', function() {
            lstOptionItem[index].remove();
        }));
        btnThem.addEventListener('click', function() {
          
            let output = `<tr class="option-item">
                                <td>
                                <input class="form-control" type="text" id="tieuDe" name="tieuDe[]">
                                </td>
                                <td>
                                <input class="form-control color-picker" type="text" id="mauSac" name="mauSac[]">
                                </td>
                                <td>
                                    <button style="outline: none; border: none" class="btn btn-danger btn-trash" type="button"><i class="bx bx-trash me-1"></i> </button>
                                </td>
                            </tr>`;
            $(".lstOption").append(output);
             $(".color-picker").colorpicker();

            lstBtnDelete = document.querySelectorAll(".btn-trash");
            lstOptionItem = document.querySelectorAll(".option-item");
            removeItem();
        });

        function removeItem() {
            lstBtnDelete.forEach((item, index) => item.addEventListener('click', function() {
                lstOptionItem[index].remove();
            }));
        }

    </script>
@endsection