@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Sales Order List</h2>
    <input type="text" placeholder="Search customer" id="search" class="form-control mb-3">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Delivery Order</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Iterasi data dummy dari controller -->
            @foreach ($sales as $index => $order)
            <tr>
                <!-- Nomor urut -->
                <td>{{ $loop->iteration }}</td>
                <!-- Kolom data -->
                <td>{{ $order['delivery_order'] }}</td>
                <td>{{ $order['customer'] }}</td>
                <td>{{ $order['address'] }}</td>
                <td>Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                <td>
                    <!-- Tombol View -->
                    <button class="btn btn-primary btn-sm view-sale" data-id="{{ $order['no'] }}">View</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tombol untuk membuat Sales Order baru -->
    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sales Order</a>

    <!-- Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleModalLabel">Order Details</h5>
                </div>
                <div class="modal-body" id="saleModalBody">
                    <!-- Loader sementara saat data sedang dimuat -->
                    <div class="text-center">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load app.js via Vite -->
@vite(['resources/js/app.js'])

@endsection
