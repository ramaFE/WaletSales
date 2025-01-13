@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container-fluid">
    <h2>Sales Order List</h2>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('sales.index') }}" class="mb-3">
        <input type="text" name="search" placeholder="Cari berdasarkan customer" value="{{ request('search') }}" class="form-control">
    </form>

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
                    {{-- Null-safe untuk customer --}}
                    <td>{{ $order->customer->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $order->customer->address ?? '-' }}</td>
                    <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('sales.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
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

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $sales->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>

    {{-- Tombol Tambah Penjualan --}}
    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sales Order</a>
</div>
@endsection
