<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

class BaoCaoThongKeExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        // return view('admin.exports.sanphambanchay', [
        //     'baocao' => 
        // ]);
    }

}
