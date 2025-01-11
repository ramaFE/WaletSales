@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container-fluid">
    <h2>Sales Order List</h2>
    <input type="text" placeholder="Search customer" id="search" class="form-control mb-3">
    
    <!-- Tabel Responsif -->
    <div class="table-responsive">
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
                    <td>{{ $sales->firstItem() + $index }}</td>
                    <td>{{ $order->delivery_order }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->customer->address }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        <!-- Tombol View -->
                        <button class="btn btn-primary btn-sm view-sale" data-id="{{ $order->id }}">View</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data sales order.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $sales->links('pagination::bootstrap-4') }}
    </div>

    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sales Order</a>

    <!-- Modal View Sales -->
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

    <!-- Modal Delete -->
    <div id="delete-modal" class="hidden">
        <div class="overlay"></div>
        <div class="modal-content">
            <h2 class="font-bold text-gray-900 mb-2">Warning!</h2>
            <p>Apakah Anda yakin akan menghapus sales order <span id="product-info" class="font-bold"></span> dari database?</p>
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-4">
                    <button type="button" id="delete-cancel" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])

@endsection
