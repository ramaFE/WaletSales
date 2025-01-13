@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h3>Stock</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Barang</th>
                    <th>Berat (Gram)</th>
                    <th>Harga (Rp)</th>
                    <th>Sisa Stok (Gram)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->kode_produk }}</td>
                    <td>{{ strtoupper($product->nama_barang) }}</td>
                    <td>{{ number_format($product->berat, 0, ',', '.') }}</td> <!-- Format berat -->
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->sisa_stok, 0, ',', '.') }}</td> <!-- Format sisa stok -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
