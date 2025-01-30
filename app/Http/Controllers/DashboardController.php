<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SalesItem;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;

        // Query untuk mendapatkan data stok dan sisa stok
        $products = DB::table('products')
            ->leftJoin('sales_items', function ($join) {
                $join->on('products.kode_produk', '=', 'sales_items.kode_produk')
                    ->on('products.nama_barang', '=', 'sales_items.nama_barang');
            })
            ->selectRaw('
                products.kode_produk,
                products.nama_barang,
                products.berat AS berat,
                products.harga,
                (products.berat - COALESCE(SUM(sales_items.berat), 0)) AS sisa_stok
            ')
            ->groupBy('products.kode_produk', 'products.nama_barang', 'products.berat', 'products.harga')
            ->paginate(10);

        // Total Barang Masuk dan Barang Terjual (Dalam Gram)
        $barangMasuk = Product::whereMonth('products.created_at', $bulanIni)->sum('berat');
        $barangTerjual = SalesItem::whereMonth('sales_items.created_at', $bulanIni)->sum('berat');

        // Perhitungan Laba yang benar
        $laba = DB::table('sales_items')
        ->join('products', 'sales_items.kode_produk', '=', 'products.kode_produk')
        ->whereMonth('sales_items.created_at', $bulanIni)
        ->selectRaw('SUM((sales_items.harga - products.harga) * sales_items.berat) AS total_laba')
        ->value('total_laba');     

        // Jika laba tidak ada, set ke 0 agar tidak error
        $laba = $laba ?? 0;


        return view('pages.dashboard', compact('products', 'barangMasuk', 'barangTerjual', 'laba'));
    }
}