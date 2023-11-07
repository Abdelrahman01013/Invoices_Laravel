<?php

namespace App\Exports;

use App\Models\Invoivices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Invoivices::all();
        return Invoivices::select('invoice_number', 'invoice_Date', 'Due_date', 'product', 'section_id', 'Amount_collection', 'Amount_Commission', 'Discount', 'Value_VAT', 'Rate_VAT', 'Total', 'Status', 'note')->get();
    }
}
