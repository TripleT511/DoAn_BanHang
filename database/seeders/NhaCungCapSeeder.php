<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhaCungCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nha_cung_caps')->insert([
            ['tenNhaCungCap' => 'Yame', 'soDienThoai' => '0123456789', 'email' => '', 'diaChi' => ' TP HCM'], ['tenNhaCungCap' => 'SWE', 'soDienThoai' => '0123456789', 'email' => '', 'diaChi' => ' TP HCM'], ['tenNhaCungCap' => '5THEWAY', 'soDienThoai' => '0123456789', 'email' => '', 'diaChi' => ' TP HCM'],
        ]);
    }
}
