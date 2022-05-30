<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('san_phams')->insert([
            [
                'sku' => '0020749', 'danh_muc_id' => 1, 'tenSanPham' => 'Áo Thun Cổ Tròn Linh Vật Bbuff Ver13', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'abc'
            ],
            [
                'sku' => '0020009', 'danh_muc_id' => 1, 'tenSanPham' => 'Áo Thun Cổ Tròn Đơn Giản 12VAHDT Văn Hiến Chi Bang M2', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 185000, 'giaKhuyenMai' => 0, 'slug' => 'def'
            ],
            [
                'sku' => '036541', 'danh_muc_id' => 2, 'tenSanPham' => 'LOGOS TEE - WHITE', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 224000, 'giaKhuyenMai' => 0, 'slug' => 'mcn'
            ],
        ]);
    }
}
