<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\HoaDon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HoaDonExport implements FromView, ShouldAutoSize, WithEvents
//FromCollection, WithMapping, WithHeadings
{
    public function view(): View
    {
        return view('admin.exports.hoadon', [
            'hoadon' => HoaDon::with('user')->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    // use Exportable;
    // /**
    // * @return \Illuminate\Support\Collection
    // */

}
