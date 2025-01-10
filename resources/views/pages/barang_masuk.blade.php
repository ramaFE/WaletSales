@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')
<div class="container-fluid"> 
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="product-list-section">
        <h2>List Barang</h2>
        <input type="text" placeholder="Search barang" id="search" class="form-control mb-3">
        
        <!-- Tabel Responsif -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Produk</th>
                        <th>Nama Barang</th>
                        <th>Berat (gram)</th>
                        <th>Harga (Rp)</th>
                        <th>Total (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $key }}</td>
                        <td>{{ $product['kode_produk'] }}</td>
                        <td>{{ $product['nama_barang'] }}</td>
                        <td>{{ number_format($product['berat'], 0, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($product['harga'], 0, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($product['berat'] * $product['harga'], 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('product.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('product.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

        <a href="{{ route('product.create') }}" class="btn btn-primary mt-3">Tambah Barang</a>
    </div>
</div>
@endsection
