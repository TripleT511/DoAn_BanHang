@extends('layouts.user')

@section('title','Trang cá nhân')

@section('css')
<style>
  .card-header {
      padding: 1.5rem 1.5rem;
      margin-bottom: 0;
      background-color: transparent;
      border-bottom: 0 solid #d9dee3;
  }


  .btn {
      cursor: pointer;
  }

  .btn:focus {
      outline: none;

  }

  .me-2 {
      margin-right: 0.5rem !important;
  }
  .btn-outline-secondary {
      color: #8592a3 !important;
      border: 1px solid #8592a3;
      background: transparent !important;
  }

  .btn-primary {
      color: #fff;
      background-color: #696cff;
      border-color: #696cff;
      box-shadow: 0 0.125rem 0.25rem 0 rgb(105 108 255 / 40%);
  }
  .text-muted {
      color: #a1acb8 !important;
  }

  .form-label {
      margin-bottom: 0.5rem;
      font-size: 0.75rem;
      font-weight: 500;
      color: #566a7f;
  }


  .input-group {
      position: relative;
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
      width: 100%;
  }

  .input-group > .form-control, .input-group > .form-select {
      position: relative;
      flex: 1 1 auto;
      width: 1%;
      min-width: 0;
  }

  .input-group-text {
      background-clip: padding-box;
  }
  .input-group-text {
      display: flex;
      align-items: center;
      padding: 0.4375rem 0.875rem;
      font-size: 0.9375rem;
      font-weight: 400;
      line-height: 1.53;
      color: #697a8d;
      text-align: center;
      white-space: nowrap;
      background-color: #fff;
      border: 1px solid #d9dee3;
      border-radius: 0.375rem 0 0 0.375rem;
  }

  .input-group > :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
      margin-left: -1px;
      border-top-left-radius: 0;
      border-bottom-left-radius: 0;
  }
  .input-group-merge .form-control:not(:first-child) {
      padding-left: 0;
      border-left: 0;
  }
  .input-group > .form-control, .input-group > .form-select {
      position: relative;
      flex: 1 1 auto;
      width: 1%;
      min-width: 0;
  }

  .gap-4 {
      gap: 1.5rem !important;
  }

  .rounded {
      border-radius: 0.375rem !important;
  }
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

        a.btn_2, .btn_2  {
    border: none;
    color: #fff;
    background: red;
    border: 1px solid red;
    outline: none;
    cursor: pointer;
    display: inline-block;
    text-decoration: none;
    padding: 12px 25px;
    color: #fff;
    font-weight: 500;
    text-align: center;
    font-size: 14px;
    font-size: 0.875rem;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    -ms-border-radius: 3px;
    border-radius: 3px;
    line-height: normal;
}

.btn-dark {
  border: none;
    color: #1f1f1f;
    background: #fff;
    border: 1px solid #1f1f1f;
    outline: none;
    cursor: pointer;
    display: inline-block;
    text-decoration: none;
    padding: 12px 25px;
    font-weight: 500;
    text-align: center;
    font-size: 14px;
    font-size: 0.875rem;
}
a.btn_2:hover, .btn_2:hover
{
    background: #fff;
    color: red;
    border: 1px solid red;
}
</style>
@endsection
@section('content')

<main class="bg_gray">
		<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Trang chủ</a></li>
					<li>Trang cá nhân</li>
				</ul>
			</div>
			<h1>Thông tin cá nhân</h1>
		</div>
		<!-- /page_header -->
        <div class="card mb-4">
                    <h5 class="card-header">Thông tin cá nhân</h5>
                    <!-- Account -->
                    @if(session('success')) 
                    <label style="color: #71dd37; margin-left: 20px;" >{{ session('success') }}</label>
                  @endif
                    <div class="card-body">
                      
                  <form method="post" action="{{ route('update', ['user' =>  Auth()->user()])}}" enctype="multipart/form-data">
                      @csrf
                     
                      @method("POST")
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                          <div class="mb-3">
                            <div class="list-preview-image">
                                <div class="preview-image-item">
                                  <div class="img-avatar online">
                                    @if(Auth()->user()->social_type != null)
                                    <img src="{{  Auth()->user()->anhDaiDien }}"alt="imgPreview" id="imgPreview">
                                    @else
                                    <img src="{{  asset('storage/'.Auth()->user()->anhDaiDien) }}" alt="imgPreview" id="imgPreview">
                                    @endif
                                  </div>
                                </div>
                            </div>
                          </div>
                          @if(Auth()->user()->social_type == null)
                          <div class="button-wrapper form-group">
                            <label for="anhDaiDien" class="btn btn_1 me-2 mb-4" tabindex="0">
                              <span class="d-none d-sm-block">Đăng ảnh đại diện mới</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input type="file" id="anhDaiDien" name="anhDaiDien"  class="form-control" hidden="" accept="image/png, image/jpeg">
                            </label>
                            <p class="text-muted mb-0">Chấp nhận ảnh JPG, GIF or PNG.</p>
                          </div>
                          @endif
                        </div>
                        <hr class="my-0">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstNahoTenme" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" id="hoTen" name="hoTen" value="{{  Auth()->user()->hoTen }}" autofocus="">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="basic-default-email">Email</label>
                            <div class="input-group input-group-merge">
                            <input
                                type="text"
                                name="email"
                                id="basic-default-email"
                                class="form-control"
                                value="{{  Auth()->user()->email }}"
                             disabled/>
                            </div>
                        </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="soDienThoai ">Số điện thoại</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">VN (+84)</span>
                              <input type="text" id="soDienThoai" name="soDienThoai" class="form-control" pattern="(09|03|07|08|05)+([0-9]{8,9})\b"   value="{{  Auth()->user()->soDienThoai }}">
                            </div>
                            <span class="text-validate" id="validate-sdt" style="display: block; color: red; margin-top: 5px;">
                              @if($errors->has('soDienThoai')) 
                              {{ $errors->first('soDienThoai') }}
                            @endif
                            </span>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="diaChi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="diaChi" name="diaChi" placeholder="Địa chỉ" value="{{  Auth()->user()->diaChi }}">
                            <span class="text-validate"  style="display: block; color: red; margin-top: 5px;">
                              @if($errors->has('diaChi')) 
                              {{ $errors->first('diaChi') }}
                            @endif
                            </span>
                           
                          </div>
                         
                          <button type="submit" class="btn btn_1 me-2">Lưu thay đổi</button>
                          @if(Auth()->user()->social_type == null)
                          <a type="button" class="btn btn_2 me-2" href="{{ route('changepass') }}" >Đổi mật khẩu</a>
                          @endif
                          <button type="button" class="btn btn-dark" onclick="history.back()">Thoát</button>
                        </form>
                      </div>
                    <!-- /Account -->
                  </div>
	</main>

@endsection
@section('js')

    <script>
      $(document).ready(function(){
			$.ajax({
				type: "GET",
				url: "/render-cart",
				dataType: "json",
				success: function (response) {
					$("#lstItemCart").html(response.newCart);
					document.querySelector(".total_drop div span").innerHTML = response.total;
					document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
					abc();

				}
			});
		});

		function abc() {
			let lstBtnDelete = document.querySelectorAll(".btn-trash");
		// Xoá giỏ hàng //
		lstBtnDelete.forEach(item => item.addEventListener('click', function() {
			console.log("a");
			$.ajax({
			type: "POST",
			url: "/remove-cart",
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				sanphamId: this.dataset.id
			},
			success: function (response) {
				$.ajax({
				type: "GET",
				url: "/render-cart",
				dataType: "json",
				success: function (response) {
					$("#lstItemCart").html(response.newCart);
					document.querySelector(".total_drop div span").innerHTML = response.total;
					document.querySelector(".dropdown-cart a strong").innerHTML = response.numberCart;
					abc();

				}
			});
			}
			});
		}));
		}

        // === Preview Image === // 
       
        $("#anhDaiDien").on("change", function (e) {
                var filePath = URL.createObjectURL(e.target.files[0]);
                $(".preview-image-item").css('display', 'flex');
                $("#imgPreview").show().attr("src", filePath);
               
            });

        // === Preview Image === // 

        let txtSoDienThoai = document.querySelector("#soDienThoai");

		txtSoDienThoai.addEventListener("blur", function(event) {
			if(!txtSoDienThoai.checkValidity()) {
			document.querySelector("#validate-sdt").innerHTML = "Số điện thoại không hợp lệ";
			} else {
				document.querySelector("#validate-sdt").innerHTML = "";
			}

		});
        
    </script>
@endsection