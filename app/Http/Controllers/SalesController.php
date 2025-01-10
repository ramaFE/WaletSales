<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    // Menampilkan daftar sales order
    public function index()
    {
        // Data dummy untuk daftar sales order
        $sales = [
            [
                'no' => 1,
                'delivery_order' => 'DO-001',
                'customer' => 'Surya',
                'address' => 'boomlama94A RT 2 RW 3',
                'total' => 15000,
            ],
            [
                'no' => 2,
                'delivery_order' => 'DO-002',
                'customer' => 'Budi',
                'address' => 'Jl. Mawar No. 10',
                'total' => 20000,
            ],
        ];

        return view('sales.index', compact('sales'));
    }

    // Menampilkan form untuk membuat sales order
    public function create()
    {
        return view('sales.create');
    }

    // Menyimpan sales order baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'delivery_order' => 'required|string',
            'customer' => 'required|string',
            'kode_barang' => 'required|array',
            'nama_barang' => 'required|array',
            'berat' => 'required|array',
            'harga' => 'required|array',
        ]);

        // Proses penyimpanan data ke database (contoh sederhana)
        // Data disimpan, misalnya:
        // Sales::create($validated);

        return redirect()->route('sales.index')->with('success', 'Sales order berhasil dibuat.');
    }

    // Menampilkan detail sales order berdasarkan nomor order
    public function show($id)
    {
        // Data dummy untuk detail sales order
        $sale = [
            'no' => $id,
            'created_at' => '19 Dec 2024',
            'due_date' => '20 Dec 2024',
            'delivery_order' => 'DO-001',
            // 'customer' => 'Surya',
            // 'address' => 'boomlama94A RT 2 RW 3',
            // 'email' => 'surya@gmail.com',
            // 'phone' => '089562',
            'items' => [
                [
                    'kode_produk' => 'BRG-001',
                    'nama_barang' => 'air putih 12mm',
                    'berat' => 1000,
                    'harga' => 5000,
                    'total' => 15000,
                ],
            ],
            'total' => 15000, // Total langsung dari subtotal tanpa PPN
        ];

        // Return blade dalam format AJAX
        return response()->json([
            'html' => view('sales.show', compact('sale'))->render(),
        ]);
    }

    public function destroy($id)
    {
        // Contoh penghapusan data di database menggunakan Eloquent
        // Sales::findOrFail($id)->delete();

        // Untuk saat ini, anggap penghapusan berhasil
        return response()->json([
            'status' => 'success',
            'message' => 'Sales order berhasil dihapus.'
        ]);
    }

    // Generate invoice dalam bentuk PDF
    public function generateInvoice($id = 1)
    {
        // Data dummy untuk invoice
        $order = [
            'order_number' => 'INV-' . $id,
            'delivery_order' => 'DO-' . $id,
            'customer' => [
                'name' => 'Surya',
            ],
            'items' => [
                [
                    'kode_produk' => 'BRG-001',
                    'nama_barang' => 'air putih 12mm',
                    'berat' => 1000,
                    'harga' => 5000,
                    'total' => 15000,
                ],
            ],
            'subtotal' => 15000,
            'total' => 15000,
        ];

        return Pdf::loadView('sales.invoice', compact('order'))->stream('Invoice-' . $id . '.pdf');
    }

    // Generate surat jalan dalam bentuk PDF
    public function generateSuratJalan($id = 1)
    {
        // Data dummy untuk surat jalan
        $customer = [
            'name' => 'Surya',
            'address' => 'boomlama94A RT 2 RW 3',
        ];

        $items = [
            [
                'nama_barang' => 'air putih 12mm',
                'berat' => 1000,
            ],
        ];

        $delivery_order = 'DO-' . $id;

        return Pdf::loadView('sales.surat_jalan', compact('customer', 'items', 'delivery_order'))->stream('SuratJalan-' . $id . '.pdf');
    }
}
