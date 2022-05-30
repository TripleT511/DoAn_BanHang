<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhanQuyen;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PhanQuyenSeeder::class,
            DanhMucSeeder::class,
            NhaCungCapSeeder::class,
            SanPhamSeeder::class
        ]);
        \App\Models\User::factory(10)->create();
    }
}
