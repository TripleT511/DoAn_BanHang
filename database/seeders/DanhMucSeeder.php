<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('danh_mucs')->insert([
            ['tenDanhMuc' => 'Đồ Nam', 'slug' => 'do-nam'],
            ['tenDanhMuc' => 'Áo thun', 'slug' => 'ao-thun'],
            ['tenDanhMuc' => 'Áo khoác', 'slug' => 'ao-khoac'],
            ['tenDanhMuc' => 'Áo sơ mi', 'slug' => 'ao-so-mi'],
            ['tenDanhMuc' => 'Quần dài', 'slug' => 'quan-dai'],

        ]);
    }
}
