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
        $sales = Sale::with('customer')->paginate(10); // Ambil data sales beserta relasi customer, 10 data per halaman
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all(); // Ambil semua data customer
        $products = Product::all();  // Ambil semua data produk
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

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
            ]);

            // Simpan data ke tabel sales
            $sale = Sale::create([
                'delivery_order' => $validated['delivery_order'],
                'customer_id' => $validated['customer_id'],
                'subtotal' => 0, // Default nilai 0, akan diupdate nanti
            ]);

            $subtotal = 0;

            foreach ($validated['products'] as $product) {
                $subtotal += $product['total'];

                // Simpan ke tabel sales_items
                SalesItem::create([
                    'sales_id' => $sale->id,
                    'kode_produk' => $product['kode_produk'],
                    'nama_barang' => $product['nama_barang'],
                    'berat' => $product['berat'],
                    'harga' => $product['harga'],
                    'total' => $product['total'],
                ]);

                // Kurangi stok dari tabel products
                $productData = Product::where('kode_produk', $product['kode_produk'])->first();
                if ($productData && $productData->stok >= $product['berat']) {
                    $productData->stok -= $product['berat'];
                    $productData->save();
                } else {
                    \Log::error('Stok tidak mencukupi untuk produk: ' . $product['kode_produk']);
                    throw new \Exception('Stok tidak mencukupi untuk produk ' . $product['kode_produk']);
                }
            }

            // Update subtotal di tabel sales
            $sale->update(['subtotal' => $subtotal]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sales order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
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
            $sale->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Sales order berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus sales order.'
            ], 500);
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
