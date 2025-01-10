@extends('layouts.app')
@section('title', 'Barang Masuk')

@section('content')
<div class="container">
    <h1>Barang Masuk</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="product-list-section">
        <h2>List Barang</h2>
        <input type="text" placeholder="Search barang" id="search" class="form-control mb-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Produk</th>
                    <th>Nama Barang</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $product['kode_produk'] }}</td>
                    <td>{{ $product['nama_barang'] }}</td>
                    <td>{{ $product['berat'] }}</td>
                    <td>{{ number_format($product['harga'], 0, ',', '.') }}</td>
                    <td>{{ number_format($product['total'], 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('product.edit', ['id' => $product['id']]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('product.destroy', ['id' => $product['id']]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('product.create') }}" class="btn btn-primary">Tambah Barang</a>
    </div>
</div>
@endsection
