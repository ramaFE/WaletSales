@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>
    <form action="{{ route('product.update', ['id' => $product['id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kode_produk">Kode Produk</label>
            <input type="text" name="kode_produk" id="kode_produk" class="form-control" value="{{ $product['kode_produk'] }}" required>
        </div>
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ $product['nama_barang'] }}" required>
        </div>
        <div class="form-group">
            <label for="berat">Berat</label>
            <input type="number" name="berat" id="berat" class="form-control" value="{{ $product['berat'] }}" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="{{ $product['harga'] }}" required>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50 mb-2">Simpan</button>
        </div>
    </form>

    <a href="{{ route('product.index') }}" class="btn btn-secondary" >
        Daftar Barang
    </a>
</div>
@endsection
