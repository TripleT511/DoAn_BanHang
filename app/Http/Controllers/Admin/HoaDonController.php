<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail3;
use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Exports\HoaDonExport;
use App\Exports\HoaDonTrongKhoangThoiGianExport;
use App\Imports\HoaDonImport;
use Maatwebsite\Excel\Excel;

class HoaDonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstHoaDon = HoaDon::with('user')->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.hoadon.index-hoadon', ['lstHoaDon' => $lstHoaDon]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function show(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function edit(HoaDon $hoaDon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HoaDon $hoadon)
    {

        $hoadon->nhan_vien_id = Auth::user()->id;
        $hoadon->khach_hang_id = $hoadon->khach_hang_id;
        $hoadon->hoTen = $hoadon->hoTen;
        $hoadon->diaChi = $hoadon->diaChi;
        $hoadon->email = $hoadon->email;
        $hoadon->soDienThoai = $hoadon->soDienThoai;
        $hoadon->ngayXuatHD = $hoadon->ngayXuatHD;
        $hoadon->tongTien = $hoadon->tongTien;
        $hoadon->ghiChu = $hoadon->ghiChu;

        if ($request->has('delete') && !empty($request->delete)) {
            $hoadon->trangThai = 5;
            $hoadon->save();
            $lstChiTietHoaDon = ChiTietHoaDon::where('hoa_don_id', $hoadon->id)->get();
            foreach ($lstChiTietHoaDon as $item) {
                $sanpham = SanPham::whereId($item->san_pham_id)->first();
                $sanpham->tonKho = $sanpham->tonKho + $item->soLuong;
                $sanpham->save();
            }
            $this->dispatch(new SendMail3($hoadon));

            return redirect()->route('hoadon.index');
        }

        switch ($request->trangThai) {
            case '1':
                $hoadon->trangThai = 1;
                $hoadon->nhan_vien_id = Auth()->user()->id;
                break;
            case '2':
                $hoadon->trangThai = 2;
                break;
            case '3':
                $hoadon->trangThai = 3;
                break;
            case '4':
                $hoadon->trangThai = 4;
                break;
            case '5':
                $hoadon->trangThai = 5;
                $lstChiTietHoaDon = ChiTietHoaDon::where('hoa_don_id', $hoadon->id)->get();
                foreach ($lstChiTietHoaDon as $item) {
                    $sanpham = SanPham::whereId($item->san_pham_id)->first();
                    $sanpham->tonKho = $sanpham->tonKho + $item->soLuong;
                    $sanpham->save();
                }
                $this->dispatch(new SendMail3($hoadon));
                break;
            default:
                $hoadon->trangThai = 1;
                break;
        }

        $hoadon->save();

        return Redirect::route('hoadon.index', ['page' => $request->page_on]);
    }

    public function locDonHang(Request $request)
    {
        $lstDonHang = HoaDon::with('user');

        switch ($request->typeFilter) {
            case "waiting":
                $lstDonHang = $lstDonHang->where('trangThai', 0)->orderBy('created_at', 'desc')->paginate(5);
                break;
            case "processed":
                $lstDonHang = $lstDonHang->where('trangThai', 1)->orderBy('created_at', 'desc')->paginate(5);
                break;
            case "packing":
                $lstDonHang = $lstDonHang->where('trangThai', 2)->orderBy('created_at', 'desc')->paginate(5);
                break;
            case "shipping":
                $lstDonHang = $lstDonHang->where('trangThai', 3)->orderBy('created_at', 'desc')->paginate(5);
                break;
            case "done":
                $lstDonHang = $lstDonHang->where('trangThai', 4)->orderBy('created_at', 'desc')->paginate(5);
                break;
            case "cancel":
                $lstDonHang = $lstDonHang->where('trangThai', 5)->orderBy('created_at', 'desc')->paginate(5);
                break;
            default:
                $lstDonHang = $lstDonHang->orderBy('created_at', 'desc')->paginate(5);
                break;
        }

        return view('admin.hoadon.index-hoadon', ['lstHoaDon' => $lstDonHang]);
    }

    public function searchDonHang(Request $request)
    {
        if ($request->filled('keyword')) {
            $stringSearch = $request->keyword;
            $lstDonHang = HoaDon::with('user')->whereHas('user', function ($query) use ($stringSearch) {
                $query->where('hoTen', 'LIKE', '%' . $stringSearch . '%');
            })->with('khachhang')->orWhereHas('khachhang', function ($query) use ($stringSearch) {
                $query->where('hoTen', 'LIKE', '%' . $stringSearch . '%');
            })->orWhere('diaChi', 'LIKE', '%' . $stringSearch . '%')->orWhere('hoTen', 'LIKE', '%' . $stringSearch . '%')->orWhere('tongTien', $stringSearch)->orWhere('email', $stringSearch)->orWhere('id', $stringSearch)->paginate(5);

            return view('admin.hoadon.index-hoadon', ['lstHoaDon' => $lstDonHang]);
        } else {
            return Redirect::route('hoadon.index');
        }
    }

    public function xemDonHang(Request $request)
    {
        $output = "";
        $tongTien = 0;
        $giamGia = 0;
        $tongThanhTien = 0;
        $trangThai = "";

        $hoadon = HoaDon::whereId($request->id)->with('user')->with('khachhang')->with('chiTietHoaDons')->with('chiTietHoaDons.sanpham')->first();
        switch ($hoadon->trangThai) {
            case 0;
                $trangThai = 'Chờ xác nhận';
                break;
            case 1;
                $trangThai = 'Đã xác nhận';
                break;
            case 2;
                $trangThai = 'Chờ giao hàng';
                break;
            case 3;
                $trangThai = 'Đang giao hàng';
                break;
            case 4;
                $trangThai = 'Hoàn thành';
                break;
            case 5;
                $trangThai = 'Đã huỷ';
                break;
            default:
                $trangThai = 'Chưa xác định';
                break;
        }

        $output .= ' <h3 class="text-center">Chi Tiết Đơn Hàng</h3>
                    <div class="text-center">Ngày tạo: ' . Carbon::createFromFormat('Y-m-d H:i:s', $hoadon->ngayXuatHD)->format('d/m/Y') . '</div>
                    <dl class="row mt-2">
                        <dt class="col-sm-3">Mã đơn hàng:</dt>
                        <dd class="col-sm-3" id="maDonHang">' . $hoadon->id . '</dd>
                        <dt class="col-sm-3">Trạng thái đơn hàng:</dt>
                        <dd class="col-sm-3">' . $trangThai . '</dd>
                        <dt class="col-sm-3 mb-3">Thông tin thanh toán</dt>
                        <dd class="col-sm-3"></dd>
                        <dt class="col-sm-3 mb-3">Thông tin khách hàng</dt>
                        <dd class="col-sm-3"></dd>
                        <dt class="col-sm-3">Họ tên:</dt>
                        <dd class="col-sm-3" id="hoTen_payment">
                          ' . ($hoadon->khachhang ? $hoadon->khachhang->hoTen : '') . '
                        </dd>
                        <dt class="col-sm-3 text-truncate">Họ tên:</dt>
                        <dd class="col-sm-3" id="hoten_billing">
                        ' . $hoadon->hoTen . '
                        </dd>
                        <dt class="col-sm-3">Email:</dt>
                        <dd class="col-sm-3" id="email">
                          ' . ($hoadon->khachhang ? $hoadon->khachhang->email : '') . '
                        </dd>
                        <dt class="col-sm-3">Địa chỉ:</dt>
                        <dd class="col-sm-3" id="diaChi">
                          ' . $hoadon->diaChi . '
                        </dd>
                        <dt class="col-sm-3">Số điện thoại:</dt>
                        <dd class="col-sm-3" id="sdt_pay">' . ($hoadon->khachhang ? $hoadon->khachhang->soDienThoai : '') . '</dd>
                        <dt class="col-sm-3">Số điện thoại:</dt>
                        <dd class="col-sm-3" id="sdt_billing">' . $hoadon->soDienThoai . '</dd>
                        
                    </dl>';
        $output .= '<table class="table">
                        <thead>
                          <tr>
                            <th class="text-left">STT</th>
                            <th class="text-left">Tên sản phẩm</th>
                            <th class="text-right">Số Lượng</th>
                            <th class="text-right">Đơn giá</th>
                            <th class="text-right">Thành tiền</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">';
        foreach ($hoadon->chiTietHoaDons as $value => $item) {
            $tongTien = (int)$item->soLuong * (float)$item->donGia;
            $output .=
                '<tr>
                    <td class="text-left">
                        ' .  $value + 1 . '
                    </td>
                    <td class="text-left">
                        ' . $item->sanpham->tenSanPham .  '
                    </td>
                    
                    <td class="text-right">
                        ' .  $item->soLuong . '
                    </td>
                    <td class="text-right">         
                        ' .  number_format($item->donGia, 0, ',', ',') . ' đ
                    </td>
                    <td class="text-right">
                        ' .  number_format($tongTien, 0, ',', ',') . ' đ
                    </td>
                </tr>';
        }
        $output .=   '</tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8">
                            
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <dt class="col-sm-5 text-right">Thành tiền: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($hoadon->tongTien, 0, ',', ',') . ' đ</dd>
                                <dt class="col-sm-5 text-right">Giảm giá: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($hoadon->giamGia, 0, ',', ',') . ' đ</dd>
                                <dt class="col-sm-5 text-right">Tổng cộng: </dt>
                                <dd class="col-sm-7 text-right">' . number_format($hoadon->tongThanhTien, 0, ',', ',') .  ' đ</dd>
                            </div>
                        </div>
                    </div>
                    ';
        Session::put('pdfHoaDon', $hoadon);
        return
            response()->json([
                'data' => $output,
            ]);
    }

    public function HoaDonPDF()
    {
        $data = Session::get('pdfHpaDon');

        // $data = [
        //     'hoadon'     => $data,
        //     'chitiethoadon' => $chitiethoadon
        // ];
        $pdf = PDF::loadView('admin.pdf.hoadon');

        return $pdf->stream();
    }

    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function ExportHoaDon()
    {
        return $this->excel->download(new HoaDonExport, 'hoadon.xlsx');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HoaDon  $hoaDon
     * @return \Illuminate\Http\Response
     */
    public function destroy(HoaDon $hoaDon)
    {
        //
    }
}
