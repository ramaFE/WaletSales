<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesOrder;
use Carbon\Carbon;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        // Mendapatkan pesan dari pengguna
        $message = strtolower(trim($request->input('message')));

        // Membersihkan input dari karakter yang tidak diinginkan
        $message = preg_replace('/[^a-z0-9\s]/', '', $message); // Menghapus karakter selain huruf, angka, dan spasi

        // Validasi input
        if (!$message) {
            return response()->json(['reply' => 'Pesan tidak boleh kosong.'], 400);
        }

        // Menangani perintah yang sesuai dengan pola tertentu
        if (preg_match('/berapa jumlah barang dengan nama (.+)/', $message, $matches)) {
            $searchTerm = trim($matches[1]);
            $reply = $this->getProductCountByName($searchTerm);
        } elseif (preg_match('/tampilkan semua produk/', $message)) {
            $reply = $this->getAllProducts();
        } elseif (preg_match('/tampilkan semua pelanggan/', $message)) {
            $reply = $this->getAllCustomers();
        } elseif (preg_match('/tampilkan semua penjualan/', $message)) {
            $reply = $this->getAllSales();
        } elseif (preg_match('/tampilkan penjualan untuk pelanggan (.+)/', $message, $matches)) {
            $customerName = trim($matches[1]);
            $reply = $this->getSalesByCustomerName($customerName);
        } elseif (preg_match('/tampilkan penjualan dengan nomor delivery (.+)/', $message, $matches)) {
            $deliveryOrder = trim($matches[1]);
            $reply = $this->getSalesByDeliveryOrder($deliveryOrder);
        } elseif (preg_match('/tampilkan barang yang dikirim pada hari ini/', $message)) {
            $reply = $this->getTodaySales();
        } else {
            $reply = "Perintah tidak dikenali.";
        }

        return response()->json(['reply' => $reply]);
    }

    // Mendapatkan jumlah produk berdasarkan nama
    private function getProductCountByName($name)
    {
        $productCount = Product::where('nama_barang', 'LIKE', "%$name%")->count();
        return $productCount === 0 
            ? "Barang dengan nama '{$name}' tidak ditemukan." 
            : "Jumlah barang dengan nama '{$name}' adalah {$productCount} unit.";
    }

    // Mendapatkan semua produk
    private function getAllProducts()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return "Tidak ada produk yang ditemukan.";
        }

        $response = "Daftar produk:\n";
        foreach ($products as $product) {
            $response .= "- {$product->nama_barang} (Kode: {$product->kode_produk}, Berat: {$product->berat} gram)\n";
        }

        return $response;
    }

    // Mendapatkan semua pelanggan
    private function getAllCustomers()
    {
        $customers = Customer::all();
        if ($customers->isEmpty()) {
            return "Tidak ada pelanggan yang ditemukan.";
        }

        $response = "Daftar pelanggan:\n";
        foreach ($customers as $customer) {
            $response .= "- {$customer->name} (ID: {$customer->id}, Contact: {$customer->contact}, Address: {$customer->address})\n";
        }

        return $response;
    }

    // Mendapatkan semua penjualan
    private function getAllSales()
    {
        $sales = SalesOrder::all();
        if ($sales->isEmpty()) {
            return "Tidak ada penjualan yang ditemukan.";
        }

        $response = "Daftar penjualan:\n";
        foreach ($sales as $sale) {
            $response .= "- Delivery Order: {$sale->delivery_order}, Customer: {$sale->customer->name}, Total: Rp" . number_format($sale->total, 0, ',', '.') . "\n";
        }

        return $response;
    }

    // Mendapatkan penjualan berdasarkan nama pelanggan
    private function getSalesByCustomerName($customerName)
    {
        $sales = SalesOrder::whereHas('customer', function ($query) use ($customerName) {
            $query->where('name', 'LIKE', "%$customerName%");
        })->get();

        if ($sales->isEmpty()) {
            return "Tidak ada penjualan untuk pelanggan '{$customerName}'.";
        }

        $response = "Daftar penjualan untuk pelanggan '{$customerName}':\n";
        foreach ($sales as $sale) {
            $response .= "- Delivery Order: {$sale->delivery_order}, Total: Rp" . number_format($sale->total, 0, ',', '.') . "\n";
        }

        return $response;
    }

    // Mendapatkan penjualan berdasarkan nomor delivery order
    private function getSalesByDeliveryOrder($deliveryOrder)
    {
        $sales = SalesOrder::where('delivery_order', $deliveryOrder)->get();

        if ($sales->isEmpty()) {
            return "Penjualan dengan nomor delivery '{$deliveryOrder}' tidak ditemukan.";
        }

        $response = "Penjualan dengan nomor delivery '{$deliveryOrder}':\n";
        foreach ($sales as $sale) {
            $response .= "- Customer: {$sale->customer->name}, Total: Rp" . number_format($sale->total, 0, ',', '.') . "\n";
        }

        return $response;
    }

    // Mendapatkan barang yang dikirim pada hari ini
    private function getTodaySales()
    {
        $today = Carbon::today();
        $sales = SalesOrder::whereDate('created_at', $today)->get();

        if ($sales->isEmpty()) {
            return "Tidak ada barang yang dikirim pada hari ini.";
        }

        $response = "Barang yang dikirim pada hari ini:\n";
        foreach ($sales as $sale) {
            $response .= "- Delivery Order: {$sale->delivery_order}, Customer: {$sale->customer->name}, Total: Rp" . number_format($sale->total, 0, ',', '.') . "\n";
        }

        return $response;
    }
}
