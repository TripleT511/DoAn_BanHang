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
          <li>Đổi mật khẩu</li>
				</ul>
			</div>
			<h1>Đổi mật khẩu</h1>
		</div>
		<!-- /page_header -->
        <div class="card mb-4">
                    <!-- Account -->
                    <div class="card-body">
                      
                  <form method="post" action="{{ route('doimatkhau', ['user' =>  Auth()->user()])}}" enctype="multipart/form-data">
                      @csrf
                      @method("POST")
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password">Mật khẩu cũ</label>
                            </div>
                            <div class="input-group input-group-merge form-group-password">
                             
                              <input type="password" id="password" class="form-control" name="password"
                                placeholder="Mật khẩu cũ.........."
                               />
                              <i id="show-password" class="fas fa-eye-slash show-password"></i>
                            </div>
                            <span class="text-validate" id="validate-pw"  style="display: block; color: red; margin-top: 5px;">
                              @if($errors->has('password')) 
                              {{ $errors->first('password') }}
                            @endif
                            </span>
                          </div>
                        
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="newpassword">Mật khẩu mới</label>
                            </div>
                            <div class="form-group form-group-password">
                                <input type="password" id="newpassword" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" class="form-control" name="newpassword"
                                placeholder="Mật khẩu mới.........."
                               />
                              <i id="show-password2" class="fas fa-eye-slash show-password"></i>
                            </div>
                            <span class="text-validate" id="validate-newpw"  style="display: block; color: red; margin-top: 5px;">
                              @if($errors->has('newpassword')) 
                              {{ $errors->first('newpassword') }}
                            @endif
                            </span>
                          </div>
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                            </div>
                            <div class="input-group input-group-merge form-group-password">
                              <input type="password" id="confirm_password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" class="form-control" name="confirm_password"
                                placeholder="Nhập lại mật khẩu........"
                                aria-describedby="confirm_password" />
                                <i id="show-password3" class="fas fa-eye-slash show-password"></i>
                            </div>
                            <span class="text-validate" id="validate-confirm"  style="display: block; color: red; margin-top: 5px;">
                              @if($errors->has('confirm_password')) 
                              {{ $errors->first('confirm_password') }}
                            @endif
                            </span>
                          </div>
                          
                          <button type="submit" class="btn btn_1 me-2">Lưu thay đổi</button>
                          <button type="button" class="btn btn-dark" onclick="history.back()">Thoát</button>
                        </form>
                      </div>
                    <!-- /Account -->
                  </div>
	</main>

@endsection

@section('js')
    <script>
      let txtNewPassword = document.querySelector("#newpassword");
      let txtConfirmPassword = document.querySelector("#confirm_password");

txtNewPassword.addEventListener("blur", function(event) {
  if(!txtNewPassword.checkValidity()) {
  document.querySelector("#validate-newpw").innerHTML = "Mật khẩu phải ít nhất 6 kí tự bao gồm chữ hoa, chữ thường và số";
  } else {
    document.querySelector("#validate-newpw").innerHTML = "";
  }

});

txtConfirmPassword.addEventListener("blur", function(event) {
  if(!txtConfirmPassword.checkValidity()) {
  document.querySelector("#validate-confirm").innerHTML = "Mật khẩu phải ít nhất 6 kí tự bao gồm chữ hoa, chữ thường và số";
  } else {
    document.querySelector("#validate-confirm").innerHTML = "";
  }

});

let txtPassword = document.querySelector("#password");
let showPassword = document.querySelector("#show-password");
let showPassword2 = document.querySelector("#show-password2");
let showPassword3 = document.querySelector("#show-password3");

showPassword.addEventListener("click", function() { 
    if(showPassword.classList.contains("fa-eye-slash")) {
        txtPassword.type = "text";
        showPassword.classList.remove("fa-eye-slash");
        showPassword.classList.add("fa-eye");
    } else {
        txtPassword.type = "password";
        showPassword.classList.remove("fa-eye");
        showPassword.classList.add("fa-eye-slash");
    }
    
});

showPassword2.addEventListener("click", function() { 
    if(showPassword2.classList.contains("fa-eye-slash")) {
        txtNewPassword.type = "text";
        showPassword2.classList.remove("fa-eye-slash");
        showPassword2.classList.add("fa-eye");
    } else {
        txtNewPassword.type = "password";
        showPassword2.classList.remove("fa-eye");
        showPassword2.classList.add("fa-eye-slash");
    }
    
});

showPassword3.addEventListener("click", function() { 
    if(showPassword3.classList.contains("fa-eye-slash")) {
        txtConfirmPassword.type = "text";
        showPassword3.classList.remove("fa-eye-slash");
        showPassword3.classList.add("fa-eye");
    } else {
        txtConfirmPassword.type = "password";
        showPassword3.classList.remove("fa-eye");
        showPassword3.classList.add("fa-eye-slash");
    }
    
});


    </script>
@endsection