<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Query untuk mendapatkan data stok dan sisa stok
        $products = DB::table('products')
            ->leftJoin('sales_items', 'products.kode_produk', '=', 'sales_items.kode_produk')
            ->selectRaw('
                products.kode_produk,
                products.nama_barang,
                products.berat AS berat,
                products.harga,
                (products.berat - COALESCE(SUM(sales_items.berat), 0)) AS sisa_stok
            ')
            ->groupBy('products.kode_produk', 'products.nama_barang', 'products.berat', 'products.harga')
            ->paginate(10); // Menggunakan pagination

        // Mengembalikan view ke dashboard
        return view('pages.dashboard', compact('products'));
    }
}
