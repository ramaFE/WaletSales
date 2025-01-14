@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="container">
    <h2>Order {{ $sale->delivery_order }}</h2>
    <p>Created at: {{ $sale->created_at ? $sale->created_at->format('d F Y') : 'N/A' }}</p>

    <h6>Customer Details</h6>
    <p>Nama: {{ $sale->customer->name }}</p>
    <p>Alamat: {{ $sale->customer->address }}</p>

    <h6>Ordered Items</h6>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Barang</th>
                <th>Berat (gram)</th>
                <th>Harga (Rp)</th>
                <th>Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
            <tr>
                <td>{{ $item->kode_produk }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ $item->berat }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h6>Total: Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</h6>

    <div>
        <a href="{{ route('sales.generateInvoice', $sale->id) }}" class="btn btn-primary" target="_blank">Cetak Invoice</a>
        <a href="{{ route('sales.generateSuratJalan', $sale->id) }}" class="btn btn-secondary" target="_blank">Cetak Surat Jalan</a>

        <!-- Tombol Hapus -->
        <button 
            class="btn btn-danger btn-sm open-delete-popup" 
            data-url="{{ route('sales.destroy', $sale->id) }}" 
            data-name="{{ $sale->customer->name }}" 
            data-code="{{ $sale->delivery_order }}">
            Hapus
        </button>

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
</div>

<!-- Tambahkan script di bawah -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.open-delete-popup');
        const deleteModal = document.getElementById('delete-modal');
        const productInfo = document.getElementById('product-info');
        const deleteForm = document.getElementById('delete-form');
        const deleteCancel = document.getElementById('delete-cancel');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const url = button.getAttribute('data-url');
                const name = button.getAttribute('data-name');
                const code = button.getAttribute('data-code');
                productInfo.textContent = ${code} (${name});
                deleteForm.setAttribute('action', url);
                deleteModal.classList.remove('hidden');
            });
        });

        deleteCancel.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });

        deleteForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const url = this.getAttribute('action');
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                alert(data.message);
                window.location.href = "{{ route('sales.index') }}"; // Redirect ke halaman index
            } else {
                alert('Gagal menghapus data.');
            }
        });
    });
</script>
@endsection
