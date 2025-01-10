<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Customer;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->get(); // Ambil data sales beserta relasi customer
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
        // Validasi input
        $validated = $request->validate([
            'delivery_order' => 'required|string|unique:sales,delivery_order',
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Simpan data ke tabel sales
        $sale = Sale::create([
            'delivery_order' => $validated['delivery_order'],
            'customer_id' => $validated['customer_id'],
            'total' => 0, // Awalnya 0, akan dihitung ulang
        ]);

        // Simpan data ke tabel sales_items
        $total = 0;
        foreach ($validated['products'] as $product) {
            $productData = Product::findOrFail($product['id']);
            $subtotal = $productData->harga * $product['quantity'];
            $total += $subtotal;

            SalesItem::create([
                'sale_id' => $sale->id,
                'product_id' => $productData->id,
                'quantity' => $product['quantity'],
                'subtotal' => $subtotal,
            ]);
        }

        // Update total di tabel sales
        $sale->update(['total' => $total]);

        return redirect()->route('sales.index')->with('success', 'Sales order berhasil dibuat!');
    }

    public function show($id)
    {
        $sale = Sale::with('items.product', 'customer')->findOrFail($id); // Ambil data sales beserta item dan customer
        return view('sales.show', compact('sale'));
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete(); // Hapus data dari database

        return response()->json([
            'status' => 'success',
            'message' => 'Sales order berhasil dihapus.',
        ]);
    }

    public function generateInvoice($id)
    {
        $sale = Sale::with('items.product', 'customer')->findOrFail($id); // Ambil data sales untuk invoice
        $pdf = Pdf::loadView('sales.invoice', compact('sale'));
        return $pdf->stream('Invoice-' . $sale->delivery_order . '.pdf');
    }

    public function generateSuratJalan($id)
    {
        $sale = Sale::with('items.product', 'customer')->findOrFail($id); // Ambil data sales untuk surat jalan
        $pdf = Pdf::loadView('sales.surat_jalan', compact('sale'));
        return $pdf->stream('SuratJalan-' . $sale->delivery_order . '.pdf');
    }
}
