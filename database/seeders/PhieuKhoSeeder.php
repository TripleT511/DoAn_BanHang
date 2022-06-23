<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhieuKhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phieu_khos')->insert([
            [
                'maDonHang' => 'PN0000001', 'nha_cung_cap_id' => 1, 'user_id' => 1,
                'ngayTao' => date("Y/m/d"), 'ghiChu' => '2020-01-01', 'loaiPhieu' => 0, 'trangThai' => 1
            ],
        ]);
    }
}
