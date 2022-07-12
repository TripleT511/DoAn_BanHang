<?php

namespace App\Exports;

use App\Models\PhieuKho;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class PhieuKhoExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('admin.exports.phieukho', [
            'phieukho' => PhieuKho::with('nhacungcap')->with('user')->orderBy('created_at', 'desc')->get()
        ]);
    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return PhieuKho::all();
    // }
}
