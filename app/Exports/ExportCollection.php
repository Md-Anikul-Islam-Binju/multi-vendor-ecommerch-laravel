<?php

namespace App\Exports;

use App\Models\VoucherTimeline;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCollection implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VoucherTimeline::all();
    }
}
