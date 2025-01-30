@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Dashboard</h2>
        <div>
            <a href="{{ route('report.excel') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="fas fa-file-excel fa-sm text-white-50"></i> Download Excel
            </a>
            <a href="{{ route('report.pdf') }}" class="btn btn-danger btn-sm shadow-sm">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Barang Masuk Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Barang Masuk (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($barangMasuk, 0, ',', '.') }} gram</div> <!-- Perbaikan: Hilangkan Rp -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Barang Terjual Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Barang Terjual (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($barangTerjual, 0, ',', '.') }} gram</div> <!-- Perbaikan: Hilangkan Rp -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Laba Bulan Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Laba (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($laba, 0, ',', '.') }}</div> <!-- Perbaikan laba -->
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <input type="text" placeholder="Search barang" id="search" class="form-control mb-3">
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
