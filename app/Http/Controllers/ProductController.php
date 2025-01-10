<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10); // Menampilkan 10 data per halaman
        return view('pages.barang_masuk', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_produk' => 'required|string|unique:products,kode_produk',
            'nama_barang' => 'required|string|max:255',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        // Hitung total
        $validated['total'] = $validated['berat'] * $validated['harga'];

        // Simpan data ke database
        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('pages.edit', compact('product'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|unique:products,kode_produk,' . $product->id,
            'nama_barang' => 'required|string|max:255',
            'berat' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);
    
        $validated['total'] = $validated['berat'] * $validated['harga'];
    
        $product->update($validated);
    
        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id); // Cari data produk
        $product->delete(); // Hapus dari database

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus!');
    }
}
