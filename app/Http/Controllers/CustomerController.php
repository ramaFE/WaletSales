<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $_request)
    {
        {
            return view('customers.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        {
            return view('customers.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Data dummy untuk mencoba
        $customer = [
            [
                'id' => $id,
                'code' => '1234',
                'name' => 'Hong A',
                'contact' => '081321654',
                'address' => 'Jalan Teluk Gong',
            ],
            [
                'id' => $id,
                'code' => '1345',
                'name' => 'Hong A',
                'contact' => '081321654',
                'address' => 'Jalan Teluk Gong',
            ],

        ];
    
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Untuk testing, cetak data input
        dd($request->all());
    }
    

    /**
     * Remove the specified resource from storage.
     */
    // Menghapus customer (simulasi)
    public function destroy($id)
    {
        // Filter data dummy untuk menghapus item berdasarkan ID
        $remainingCustomers = collect($this->customers)->filter(function ($customer) use ($id) {
            return $customer['id'] != $id;
        });

        // Menampilkan data yang tersisa sebagai simulasi
        return back()->with('success', 'Customer deleted successfully!')->with('customers', $remainingCustomers);
    }
}
