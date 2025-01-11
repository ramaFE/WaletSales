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
                            <!-- Tombol Edit -->
                            <a href="{{ route('product.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Tombol Delete -->
                            <button 
                                type="button" 
                                class="btn btn-danger btn-sm open-delete-popup" 
                                data-url="{{ route('product.destroy', $product) }}" 
                                data-name="{{ $product['nama_barang'] }}" 
                                data-code="{{ $product['kode_produk'] }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal Delete -->
            <div id="delete-modal" class="hidden">
                <div class="overlay"></div>
                <div class="modal-content">
                    <h2 class="text-gray-900 font-bold">Warning!</h2>
                    <p>Apakah Anda yakin akan menghapus <span id="product-info" class="font-bold"></span> dari database?</p>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-actions">
                            <button id="delete-cancel" type="button" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>

        <!-- Tombol Tambah Barang -->
        <a href="{{ route('product.create') }}" class="btn btn-primary mt-3">Tambah Barang</a>
    </div>
</div>
@endsection
