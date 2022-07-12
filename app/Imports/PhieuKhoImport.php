<?php

namespace App\Imports;

use App\Models\PhieuKho;
use Maatwebsite\Excel\Concerns\ToModel;

class PhieuKhoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PhieuKho([
            //
        ]);
    }
}
