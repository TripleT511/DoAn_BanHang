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
            ['tenDanhMuc' => 'Danh mục 1', 'slug' => 'danh-muc-1'],
            ['tenDanhMuc' => 'Danh mục 2', 'slug' => 'danh-muc-2'],
            ['tenDanhMuc' => 'Danh mục 3', 'slug' => 'danh-muc-3'],
            ['tenDanhMuc' => 'Danh mục 4', 'slug' => 'danh-muc-4'],
            ['tenDanhMuc' => 'Danh mục 5', 'slug' => 'danh-muc-5'],

        ]);
    }
}
