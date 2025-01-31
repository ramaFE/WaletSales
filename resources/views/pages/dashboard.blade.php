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
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Barang Masuk (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($barangMasuk, 0, ',', '.') }} gram</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Barang Terjual (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($barangTerjual, 0, ',', '.') }} gram</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Laba (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($laba, 0, ',', '.') }}</div>
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
                    <td>{{ number_format($product->berat, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($product->sisa_stok, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Grafik Barang Masuk -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Grafik Barang Masuk per Bulan</h5>
            <canvas id="productChart"></canvas>
        </div>
    </div>

    <!-- Grafik Laba Penjualan -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Grafik Laba Penjualan per Bulan</h5>
            <canvas id="profitChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx1 = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Jumlah Product Masuk (gram)',
                    data: {!! json_encode($weights) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        var ctx2 = document.getElementById('profitChart').getContext('2d');
        var profitChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Laba Penjualan (Rp)',
                    data: {!! json_encode($revenues) !!},
                    borderColor: 'rgba(34, 197, 94, 1)', // Warna hijau
                    backgroundColor: 'rgba(34, 197, 94, 0.2)', // Warna hijau transparan
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4, // Membuat garis lebih halus
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Rp ' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

    </script>

    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
