<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VoucherTimelineExport implements FromView
{
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }
    public function view(): View
    {
        return view('admin.order.voucher.voucherTimelineExport', [
            'voucherTimelines' =>  $this->data
        ]);
    }
}
