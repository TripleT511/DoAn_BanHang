<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhanQuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phan_quyens')->insert([
            ['tenViTri' => 'Admin', 'viTri' => 0],
            ['tenViTri' => 'Nhân viên', 'viTri' => 1],
            ['tenViTri' => 'Khách hàng', 'viTri' => 2],
        ]);
    }
}
