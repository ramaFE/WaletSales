<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\SalesItem;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->month;

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
            ->paginate(10);

        // Total Barang Masuk dan Barang Terjual (Dalam Gram)
        $barangMasuk = Product::whereMonth('created_at', $bulanIni)->sum('berat');
        $barangTerjual = SalesItem::whereMonth('created_at', $bulanIni)->sum('berat');

        // Perhitungan Laba
        $laba = DB::table('sales_items')
            ->join('products', 'sales_items.kode_produk', '=', 'products.kode_produk')
            ->whereMonth('sales_items.created_at', $bulanIni)
            ->selectRaw('SUM((sales_items.harga - products.harga) * sales_items.berat) AS total_laba')
            ->value('total_laba') ?? 0;

        // Ambil jumlah barang masuk per bulan untuk chart
        $productsPerMonth = Product::selectRaw('MONTH(created_at) as month, SUM(berat) as total_weight')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Ambil laba per bulan untuk chart area
        $labaPerMonth = DB::table('sales_items')
            ->join('products', 'sales_items.kode_produk', '=', 'products.kode_produk')
            ->selectRaw('MONTH(sales_items.created_at) as month, SUM((sales_items.harga - products.harga) * sales_items.berat) as total_laba')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data untuk grafik
        $months = [];
        $weights = [];
        $revenues = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
            $weights[] = $productsPerMonth->where('month', $i)->sum('total_weight');
            $revenues[] = $labaPerMonth->where('month', $i)->sum('total_laba');
        }

        return view('pages.dashboard', compact('products', 'barangMasuk', 'barangTerjual', 'laba', 'months', 'weights', 'revenues'));
    }
}
