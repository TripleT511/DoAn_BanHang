<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChiTietPhieuKhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chi_tiet_phieu_khos')->insert([
            [
                'phieu_kho_id' => 1, 'san_pham_id' => 1, 'sku' => "SP00001", 'soLuong' => 10, 'donVi' => 'Cái', 'gia' => 100000, 'tongTien' => 1000000
            ],
        ]);
    }
}
