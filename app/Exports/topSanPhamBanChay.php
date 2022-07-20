<?php

namespace App\Exports;

use App\Models\SanPham;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class topSanPhamBanChay implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        // dd($this->data);
        return view('admin.exports.sanphambanchay', $this->data);
    }
}
