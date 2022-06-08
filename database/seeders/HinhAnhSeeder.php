<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HinhAnhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hinh_anhs')->insert([
            [
                'san_pham_id' => 1, 'hinhAnh' => 'images/san-pham/ScUAesEiYs8HHM0e1yRsf1lyoNzlwWG1T2GTiP0E.jpg',
            ],
            [
                'san_pham_id' => 1, 'hinhAnh' => 'images/san-pham/s0rZbQcZZBg7Kdudz14N1RAuTDOf43aNeDNWEr04.jpg',
            ]
        ]);
    }
}
