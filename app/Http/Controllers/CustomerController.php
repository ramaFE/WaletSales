<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all(); // Ambil semua data customer
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'code' => 'required|string|unique:customers,code',
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        // Simpan data ke database
        Customer::create($validated);

        return redirect()->route('customer.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id); // Ambil data customer berdasarkan ID
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'code' => 'required|string|unique:customers,code,' . $id,
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        // Update data di database
        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return redirect()->route('customer.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id); // Cari data customer
        $customer->delete(); // Hapus dari database

        return redirect()->route('customer.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}

