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
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset('storage/images/user-default.jpg') }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper form-group">
                          <label for="upload" class="btn btn_1 me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                          </label>
                          <p class="text-muted mb-0">Chấp nhận ảnh JPG, GIF or PNG.</p>
                        </div>
                      </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" >
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" id="firstName" name="hoTen" value="John" autofocus="">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Email</label>
                            <input class="form-control" type="text" name="email" id="lastName" value="Doe">
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Số điện thoại</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">VN (+84)</span>
                              <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="202 555 0111">
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                          </div>
                        </div>
                        <div class="mt-2 form-group">
                          <button type="submit" class="btn btn_1 me-2">Lưu thay đổi</button>
                          <button type="reset" class="btn btn_1 btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
	</main>

@endsection