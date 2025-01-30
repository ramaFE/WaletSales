<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sale::select('id', 'delivery_order', 'customer_id', 'subtotal', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Delivery Order', 'Customer', 'Total', 'Tanggal'];
    }
}

