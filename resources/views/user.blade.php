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
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" hidden="" accept="image/png, image/jpeg">
                          </label>
                          <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

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
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
	</main>

@endsection