@extends('layouts.admin')

@section('title','Quản lý Mã Giảm Giá')
@section('css')
    <style>
      .modal-backdrop.fade {
        display: none;
      } 
      .modal-backdrop.show {
        z-index: 1089;
        display: block;
      }
      .modal-dialog {
        max-width: 80%;
        width: 80%;
      }
      .list-discount {
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 10px;
      }
      .discount-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 150px;
        background: #fff;
        box-shadow: 0 2px 6px 0 rgb(67 89 113 / 12%);
        border-radius: 8px;
      }

      .discount-item .img {
        position: relative;
        width: 150px;
        height: 100%;
        padding: 20px;
        border-right: 3px dashed #7e8d9d;
      }

      .discount-content {
        flex: 0 0 calc(100% - 150px);
        width: calc(100% - 150px);
        padding: 20px 20px 20px 30px;
        display: flex;
        align-items: flex-start;
      }

      .discount-item .img:after,
      .discount-item .img:before {
        position: absolute;
        content: "";
        width: 30px;
        height: 30px;
        background-color: #f5f5f9;
        border-radius: 50%;
        right: -17px;
      }

      .discount-item .img:after {
        bottom: -15px;
        box-shadow: inset 0 4px 3px -1px rgb(67 89 113 / 10%);
      }
      
      .discount-item .img::before {
        top: -15px;
        box-shadow: inset 0px -2px 6px -3px rgb(67 89 113 / 12%);
      }

      .discount-item .img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: flex;
        margin: auto;
      }
      .discount-content .title {
        flex: 0 0 250px;
        width: 250px;

      }

      .discount-content .title > p:nth-of-type(1) {
        margin-bottom: 10px;
      }

      .discount-content .title > p:nth-of-type(2) {
        margin-bottom: 0;
      }

      .discount-content .date {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 0 10px;
        gap: 10px;
      }

      .discount-content .date .date-item i,
      .discount-content.date.date-item span {
        display: inline-block;
      } 

      .discount-content .date .date-item i {
        margin-right: 5px;
      }

      .discount-content .date .date-item {
          display: flex;
          flex-wrap: wrap;
          align-items: center;
      }

      .code-wrapper {
        padding: 0 20px;
        text-align: center;
        flex: 1;
      }

      .code-wrapper .code {
        padding: 10px 25px;
        background: #f5f5f9;
        border: 2px dashed #696CFF;
        width: fit-content;
        margin: 0 auto 5px;
      }

      .code-wrapper .code p {
        margin-bottom: 0;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
      }

      .discount-content .action {
          display: flex;
          flex-direction: column;
          gap: 10px;
          align-items: flex-end;
          flex: 0 0 100px;
          width: 100px;
      }
    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3">Mã giảm giá</h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
              <li class="nav-item">
                  <a class="nav-link active" href="{{ route('discount.create') }}"><i class="bx bx-plus"></i> Thêm mới</a>
              </li>
              <li class="nav-item "  style="margin-left: 10px;">
                  <a class="nav-link bg-success text-white" href="{{ route('maDangChay') }}"><i class='bx bxs-gift'></i> Mã giảm giá sắp & đang chạy</a>
              </li>
              <li class="nav-item " style="margin-left: 10px;">
                  <a class="nav-link bg-danger text-white"  href="{{ route('maHetHan') }}"><i class='bx bx-notification-off'></i> Mã giảm giá đã & gần hết hạn</a>
              </li>
            </ul>
            <div class="list-discount">
                @foreach ($lstDiscount as $item)
                  <div class="discount-item">
                  <div class="img">
                    <img src="{{ asset('storage/'.$item->hinhAnh) }}" alt="{{ $item->tenMa }}">
                  </div>
                  <div class="discount-content">
                    <div class="title">
                      <p><strong>{{ $item->tenMa }}</strong></p>
                      <p>Áp dụng cho: Tất cả đơn hàng</p>
                    </div>
                    <div class="date">
                      <div class="date-item">
                        <i class='bx bxs-calendar'></i>
                       <span> Bắt đầu: {{ date('d-m-Y', strtotime($item->ngayBatDau)) }} </span>
                      </div>
                      <div class="date-item">
                        <i class='bx bxs-calendar'></i>
                          <span>Kết thúc: {{ date('d-m-Y', strtotime($item->ngayKetThuc)) }} </span>
                      </div>
                    </div>
                    <div class="code-wrapper">
                      <div class="code">
                        <p>
                          {{ $item->code }}
                        </p>
                      </div>
                      <div class="code-count">
                        <span>
                          Số lần sử dụng: {{ $item->soLuong == null ? "Không giới hạn" : $item->soLuong }}
                        </span>
                      </div>
                    </div>
                    <div class="action">
                      <a class="btn btn-success" href="{{ route('discount.edit', ['discount' => $item]) }}">
                            <i class="bx bx-edit-alt me-1"></i>
                          </a>
                      <button type="button"  class="btn btn-danger btn-delete-discount" data-route="{{ route('discount.destroy', ['discount'=>$item]) }}" data-bs-toggle="modal" data-bs-target="#basicModal">
                      <i class="bx bx-trash me-1"></i>
                      </button>
                    </div>
                  </div>
                  </div>
                @endforeach
            </div>
              <div class="pagination__wrapper">
                <ul class="pagination">
                  {!!$lstDiscount->withQueryString()->links() !!}
                </ul>
              </div>
              <!--/ Responsive Table -->
            </div>
<div class="modal-backdrop fade "></div>
{{-- Model Delete --}}
<div class="modal fade" id="basicModal" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog" role="document" style="max-width: 30%; width: 30%;">
    <div class="modal-content">
      <div class="modal-header justify-content-center py-4">
        <h5 class="modal-title text-center w-100" id="exampleModalLabel1">Bạn có chắc chắn muốn xoá không ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" >
         Đóng
        </button>
         <form class="d-inline-block" method="post" id="form-delete" action="">
          @csrf
          @method("DELETE")
          <button style="outline: none; border: none" class="btn btn-danger" type="submit"> Xác nhận </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>
    
  let lstBtnDeleteRoute = document.querySelectorAll(".btn-delete-discount");
  lstBtnDeleteRoute.forEach((item) => item.addEventListener("click", function() {
    let linkRoute = item.dataset.route;
    let formDel = document.querySelector("#form-delete");
    formDel.action  = linkRoute;
  }));

</script>

@endsection