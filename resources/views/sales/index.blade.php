@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Sales Order List</h2>
    <input type="text" placeholder="Search customer" id="search" class="form-control mb-3">
    
    <table class="table table-bordered">
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
            @forelse ($sales as $index => $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->delivery_order }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>{{ $order->customer->address }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td>
                    <button class="btn btn-primary btn-sm view-sale" data-id="{{ $order->id }}">View</button>
                    <form action="{{ route('sales.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus sales order ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data sales order.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sales Order</a>

    <!-- Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleModalLabel">Order Details</h5>
                </div>
                <div class="modal-body" id="saleModalBody">
                    <div class="text-center">
                        <p>Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])

@endsection
