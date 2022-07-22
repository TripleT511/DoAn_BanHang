<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThuocTinhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thuoc_tinhs')->insert([
            [
                'tenThuocTinh' => 'Size', 'loaiThuocTinh' => 'Text'
            ],
            [
                'tenThuocTinh' => 'Màu sắc', 'loaiThuocTinh' => 'Color'
            ]
        ]);
    }
}
