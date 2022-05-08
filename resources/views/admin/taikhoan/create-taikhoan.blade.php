@extends('layouts.admin')

@section('title','Thêm tài khoản')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tài khoản/</span> Thêm tài khoản</h4>
    <!-- Basic Layout -->
    <div class="row">
        
        <div class="col-xl">
            <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            </div>
            <div class="card-body">
                <form>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-fullname">Họ tên</label>
                    <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" />
                </div>
                <div class="mb-3">
                    <label for="html5-datetime-local-input" class="col-form-label">Ngày sinh</label>
                    <input class="form-control" type="datetime-local" value="2021-06-18T12:30:00" id="html5-datetime-local-input">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Địa chỉ</label>
                    <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc." />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-email">Email</label>
                    <div class="input-group input-group-merge">
                    <input
                        type="text"
                        id="basic-default-email"
                        class="form-control"
                        placeholder="john.doe"
                        aria-label="john.doe"
                        aria-describedby="basic-default-email2"
                    />
                    <span class="input-group-text" id="basic-default-email2">@example.com</span>
                    </div>
                    <div class="form-text">Bạn có thể sử dụng chữ cái, số & dấu chấm</div>
                </div>
                <div class="mb-3">
                    <label for="html5-password-input" class="form-label">Mật khẩu</label>
                    <input class="form-control" type="password" value="password" id="html5-password-input">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-phone">Số điện thoại</label>
                    <input
                    type="text"
                    id="basic-default-phone"
                    class="form-control phone-mask"
                    placeholder="037 934 5986"
                    />
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ảnh đại diện</label>
                    <input class="form-control" type="file" id="formFile">
                </div>
                <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Phân quyền</label>
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                          <option selected="">Open this select menu</option>
                          <option value="1">Admin</option>
                          <option value="2">Nhân viên</option>
                          <option value="3">Người dùng</option>
                        </select>
                      </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-default-message">Message</label>
                    <textarea
                    id="basic-default-message"
                    class="form-control"
                    placeholder="Hi, Do you have a moment to talk Joe?"
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
            </div>
        </div>
    
    </div>
</div>
@endsection