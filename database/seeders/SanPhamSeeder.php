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
                'sku' => 'SP000001', 'danh_muc_id' => 1, 'tenSanPham' => 'Sản phẩm 01', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-01'
            ],
            [
                'sku' => 'SP000002', 'danh_muc_id' => 2, 'tenSanPham' => 'Sản phẩm 02', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-02'
            ],
            [
                'sku' => 'SP000003', 'danh_muc_id' => 3, 'tenSanPham' => 'Sản phẩm 03', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-03'
            ],
            [
                'sku' => 'SP000004', 'danh_muc_id' => 3, 'tenSanPham' => 'Sản phẩm 04', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-04'
            ],
            [
                'sku' => 'SP000005', 'danh_muc_id' => 4, 'tenSanPham' => 'Sản phẩm 05', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-05'
            ],
            [
                'sku' => 'SP000006', 'danh_muc_id' => 5, 'tenSanPham' => 'Sản phẩm 06', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-06'
            ],
            [
                'sku' => 'SP000007', 'danh_muc_id' => 3, 'tenSanPham' => 'Sản phẩm 07', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-07'
            ],
            [
                'sku' => 'SP000008', 'danh_muc_id' => 3, 'tenSanPham' => 'Sản phẩm 08', 'moTa' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'noiDung' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry",
                'dacTrung' => 0,
                'gia' => 285000, 'giaKhuyenMai' => 0, 'slug' => 'san-pham-08'
            ]

        ]);
    }
}
