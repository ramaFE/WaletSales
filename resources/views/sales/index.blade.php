@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="container">
    <h2>Sales Order List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Delivery Order</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $order)
            <tr>
                <td>{{ $order['no'] }}</td>
                <td>{{ $order['kode_barang'] }}</td>
                <td>{{ $order['delivery_order'] }}</td>
                <td>{{ $order['customer'] }}</td>
                <td>{{ $order['address'] }}</td>
                <td>{{ $order['total'] }}</td>
                <td>

                <!-- Tombol View -->
                <button class="btn btn-primary btn-sm view-sale">View</button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sales Order</a>

    <!-- Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="saleModalBody">
                    <!-- Data akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('click', '.view-sale', function () {
        const saleId = $(this).data('id');
        $.ajax({
            url: `/sales/${saleId}`,
            method: 'GET',
            success: function (response) {
                $('#saleModalBody').html(response.html); // Masukkan data ke dalam modal
                $('#saleModal').modal('show'); // Tampilkan modal
            },
            error: function () {
                alert('Gagal memuat data. Silakan coba lagi.');
            }
        });
    });
</script>

@endsection
