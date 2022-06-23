<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


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
            SanPhamSeeder::class,
            ThuocTinhSeeder::class,
            HinhAnhSeeder::class,
        ]);
        \App\Models\User::factory(10)->create();
        $this->call([

            PhieuKhoSeeder::class,
            ChiTietHoaDonSeeder::class
        ]);
    }
}
