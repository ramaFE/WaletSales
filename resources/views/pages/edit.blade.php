@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Barang</h1>

    <form action="{{ route('product.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group mb-3">
            <label for="kode_produk">Kode Produk</label>
            <input 
                type="text" 
                name="kode_produk" 
                id="kode_produk" 
                class="form-control @error('kode_produk') is-invalid @enderror" 
                value="{{ old('kode_produk', $product->kode_produk) }}" 
                required>
            @error('kode_produk')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nama_barang">Nama Barang</label>
            <input 
                type="text" 
                name="nama_barang" 
                id="nama_barang" 
                class="form-control @error('nama_barang') is-invalid @enderror" 
                value="{{ old('nama_barang', $product->nama_barang) }}" 
                required>
            @error('nama_barang')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="berat">Berat (gram)</label>
            <input 
                type="number" 
                name="berat" 
                id="berat" 
                class="form-control @error('berat') is-invalid @enderror" 
                value="{{ old('berat', $product->berat) }}" 
                required>
            @error('berat')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="harga">Harga (Rp)</label>
            <input 
                type="number" 
                name="harga" 
                id="harga" 
                class="form-control @error('harga') is-invalid @enderror" 
                value="{{ old('harga', $product->harga) }}" 
                required>
            @error('harga')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-50 mb-2">Simpan</button>
        </div>
    </form>

    <a href="{{ route('product.index') }}" class="btn btn-secondary">
        Daftar Barang
    </a>
</div>
@endsection
