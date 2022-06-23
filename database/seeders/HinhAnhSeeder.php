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
                'san_pham_id' => 1, 'hinhAnh' => 'images/san-pham/01.jpg',
            ],
            [
                'san_pham_id' => 1, 'hinhAnh' => 'images/san-pham/02.jpg',
            ],
            [
                'san_pham_id' => 2, 'hinhAnh' => 'images/san-pham/03.jpg',
            ],
            [
                'san_pham_id' => 2, 'hinhAnh' => 'images/san-pham/04.jpg',
            ],
            [
                'san_pham_id' => 3, 'hinhAnh' => 'images/san-pham/05.jpg',
            ],
            [
                'san_pham_id' => 3, 'hinhAnh' => 'images/san-pham/06.jpg',
            ],
            [
                'san_pham_id' => 4, 'hinhAnh' => 'images/san-pham/07.jpg',
            ],
            [
                'san_pham_id' => 4, 'hinhAnh' => 'images/san-pham/08.jpg',
            ],
            [
                'san_pham_id' => 5, 'hinhAnh' => 'images/san-pham/09.jpg',
            ],
            [
                'san_pham_id' => 5, 'hinhAnh' => 'images/san-pham/10.jpg',
            ],
            [
                'san_pham_id' => 6, 'hinhAnh' => 'images/san-pham/11.jpg',
            ],
            [
                'san_pham_id' => 6, 'hinhAnh' => 'images/san-pham/12.jpg',
            ],
            [
                'san_pham_id' => 7, 'hinhAnh' => 'images/san-pham/13.jpg',
            ],
            [
                'san_pham_id' => 7, 'hinhAnh' => 'images/san-pham/14.jpg',
            ],
            [
                'san_pham_id' => 8, 'hinhAnh' => 'images/san-pham/15.jpg',
            ],
            [
                'san_pham_id' => 8, 'hinhAnh' => 'images/san-pham/16.jpg',
            ]
        ]);
    }
}
