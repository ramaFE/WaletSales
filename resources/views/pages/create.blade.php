@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Barang</h1>
    
    <form action="{{ route('product.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="kode_produk">Kode Produk</label>
            <input type="text" name="kode_produk" id="kode_produk" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="berat">Berat</label>
            <input type="number" name="berat" id="berat" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" class="form-control" readonly>
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
