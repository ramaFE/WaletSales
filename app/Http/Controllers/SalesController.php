<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class SalesController extends Controller
{
    public function index()
    {
        // Data penjualan (harusnya dari database)
        $sales = [
            [
                'no' => 1,
                'kode_barang' => 'BRG-001',
                'delivery_order' => 'SJ-30e363c0',
                'customer' => 'Surya',
                'address' => 'boomlama94...',
                'total' => 'Rp. 16.650,00',
            ],
            [
                'no' => 2,
                'kode_barang' => 'BRG-002',
                'delivery_order' => 'SJ-1a1667e0',
                'customer' => 'Surya',
                'address' => 'boomlama94...',
                'total' => 'Rp. 16.650,00',
            ],
        ];

        return view('sales.index', compact('sales'));
    }

    public function show($id)
    {
        // Dummy data penjualan berdasarkan ID
        $sales = [
            1 => [
                'no' => 1,
                'kode_barang' => 'BRG-001',
                'delivery_order' => 'SJ-30e363c0',
                'customer' => 'Surya',
                'address' => 'boomlama94...',
                'total' => 'Rp. 16.650,00',
                'items' => [
                    [
                        'No' => 1,
                        'Kode Barang' => 'budi',
                        'Nama Barang' => 'Patahan',
                        'Berat' => 200,
                        'Harga' => 5000,
                        'Total' => 1000000,
                    ],
                ],
            ],
            2 => [
                'no' => 2,
                'kode_barang' => 'BRG-002',
                'delivery_order' => 'SJ-1a1667e0',
                'customer' => 'Surya',
                'address' => 'boomlama94...',
                'total' => 'Rp. 16.650,00',
                'items' => [
                    [
                        'No' => 2,
                        'Kode Barang' => 'budi',
                        'Nama Barang' => 'Patah KW',
                        'Berat' => 500,
                        'Harga' => 4000,
                        'Total' => 2000000,
                    ],
                ],
            ],
        ];

        if (!isset($sales[$id])) {
            abort(404, 'Data tidak ditemukan');
        }

        $sale = $sales[$id];

        // Return data ke view
        return response()->json([
            'html' => view('sales.view', compact('sale'))->render(),
        ]);
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_barang.*' => 'required',
            'delivery_order' => 'required',
            'customer' => 'required',
            'nama_barang.*' => 'required',
            'berat.*' => 'required|numeric',
            'harga.*' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ], [
            'required' => ':attribute harus diisi.',
            'numeric' => ':attribute harus berupa angka.',
        ]);

        // Logika penyimpanan ke database (sesuaikan dengan model)
        // Contoh: Sales::create($validated);

        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dibuat!');
    }

    public function generateInvoice()
    {
        // Dummy data produk
        $dummyData = [
            [
                'id' => 1,
                'kode_produk' => 'budi',
                'nama_barang' => 'Patahan',
                'berat' => 200,
                'harga' => 5000,
                'total' => 1000000,
            ],
            [
                'id' => 2,
                'kode_produk' => 'budi',
                'nama_barang' => 'Patah KW',
                'berat' => 500,
                'harga' => 4000,
                'total' => 2000000,
            ],
            [
                'id' => 3,
                'kode_produk' => 'budi',
                'nama_barang' => 'Kakian',
                'berat' => 1000,
                'harga' => 3000,
                'total' => 3000000,
            ],
        ];

        // Hitung subtotal
        $subtotal = array_sum(array_column($dummyData, 'total'));

        // Siapkan data untuk view
        $data = [
            'dummyData' => $dummyData,
            'subtotal' => $subtotal,
            'tanggal' => now()->format('d F Y'),
        ];

        // Render PDF
        $pdf = PDF::loadView('invoice', $data);
        return $pdf->stream('Invoice.pdf');
    }
}
