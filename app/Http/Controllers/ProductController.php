<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $dummyData = [
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

    // Tampilkan semua data
    public function index()
    {
        $products = $this->dummyData;
        return view('pages.barang_masuk', compact('products'));
    }

    // Tampilkan form tambah data
    public function create()
    {
        return view('pages.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'kode_produk' => 'required',
            'nama_barang' => 'required',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        // Simulasi menyimpan data
        $newProduct = $request->all();
        return redirect()->route('product.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Tampilkan form edit data
    public function edit($id)
    {
        $product = collect($this->dummyData)->firstWhere('id', $id);
        return view('pages.edit', compact('product'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'kode_produk' => 'required',
            'nama_barang' => 'required',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        // Simulasi update data
        $updatedProduct = $request->all();
        return redirect()->route('product.index')->with('success', 'Barang berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        // Simulasi menghapus data
        return redirect()->route('product.index')->with('success', 'Barang berhasil dihapus!');
    }
}
