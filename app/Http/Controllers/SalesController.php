<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Customer;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->paginate(10); // Ambil data sales beserta relasi customer
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all(); // Ambil semua data customer
        return view('sales.create', compact('customers'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        \Log::info('Store method dipanggil');
        \Log::info('Request diterima:', $request->all());


        try {
            // Validasi input
            $validated = $request->validate([
                'delivery_order' => 'required|string|unique:sales,delivery_order',
                'customer_id' => 'required|exists:customers,id',
                'products' => 'required|array|min:1',
                'products.*.kode_produk' => 'required|string|exists:products,kode_produk',
                'products.*.nama_barang' => 'required|string',
                'products.*.berat' => 'required|numeric|min:0.01',
                'products.*.harga' => 'required|numeric|min:0',
                'products.*.total' => 'required|numeric|min:0', 
                'subtotal' => 'required|numeric|min:0',
            ]);
        
            // Simpan data ke tabel sales
            $sale = Sale::create([
                'delivery_order' => $validated['delivery_order'],
                'customer_id' => $validated['customer_id'],
                'subtotal' => $validated['subtotal'],
            ]);
            \Log::info('Data sales berhasil disimpan:', $sale->toArray());
        
            foreach ($validated['products'] as $product) {
                // Simpan item ke tabel sales_items
                $salesItem = SalesItem::create([
                    'sales_id' => $sale->id,
                    'kode_produk' => $product['kode_produk'],
                    'nama_barang' => $product['nama_barang'],
                    'berat' => $product['berat'],
                    'harga' => $product['harga'],
                    'subtotal' => $product['total'],
                ]);
                \Log::info('Data sales item berhasil disimpan:', $salesItem->toArray());
            }
        
            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
    }

    public function show($id)
    {
        $sale = Sale::with('items', 'customer')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function destroy($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->delete(); // Hapus data dari tabel sales
    
            return redirect()->route('sales.index')->with('success', 'Sales order berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus sales order.']);
        }
    }
    
    public function generateInvoice($id)
    {
        $sale = Sale::with('items', 'customer')->findOrFail($id);
        $pdf = Pdf::loadView('sales.invoice', compact('sale'));
        return $pdf->stream('Invoice-' . $sale->delivery_order . '.pdf');
    }

    public function generateSuratJalan($id)
    {
        $sale = Sale::with('items', 'customer')->findOrFail($id);
        $customer = $sale->customer;

        $pdf = Pdf::loadView('sales.surat_jalan', compact('sale', 'customer'));
        return $pdf->stream('SuratJalan-' . $sale->delivery_order . '.pdf');
    }
}
