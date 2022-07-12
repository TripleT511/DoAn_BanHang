<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\HoaDon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HoaDonExport implements FromView, ShouldAutoSize
//FromCollection, WithMapping, WithHeadings
{
    public function view(): View
    {
        return view('admin.exports.hoadon', [
            'hoadon' => HoaDon::with('user')->orderBy('created_at', 'desc')->get()
        ]);
    }

    // use Exportable;
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    
}
