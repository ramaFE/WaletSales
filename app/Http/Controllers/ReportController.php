<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Generate laporan Excel
    public function exportExcel()
    {
        return Excel::download(new ReportExport, 'Laporan_Penjualan.xlsx');
    }

    // Generate laporan PDF
    public function exportPDF()
    {
        $products = Product::all();
        $sales = Sale::all();
        $pdf = Pdf::loadView('reports.pdf', compact('products', 'sales'));
        return $pdf->download('Laporan_Penjualan.pdf');
    }
}
