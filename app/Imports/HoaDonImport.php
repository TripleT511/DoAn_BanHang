<?php

namespace App\Imports;

use App\Models\HoaDon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HoaDonImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HoaDon([
            'nhan_vien_id'  => $row['nhanvien'],
            'khach_hang_id' => $row['khachhang'],
            'hoTen'         => $row['hoten'],
            'diaChi'        => $row['diachi'], 
            'email'         => $row['email'], 
            'soDienThoai'   => $row['sodienthoai'], 
            'ngayXuatHD'    => $row['ngaytaohd'], 
            'tongTien'      => $row['tongtien'], 
            'giamGia'       => $row['giamgia'], 
            'tongThanhTien' => $row['tongthanhtien'], 
            'ghiChu'        => $row['ghichu'], 
            'trangThaiThanhToan'    => $row['trangthaithanhtoan'],
            'trangThai'     => $row['trangthai'],  
             
        ]);
    }
}
