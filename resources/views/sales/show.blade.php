<div class="container">
    <div class="modal-header">
        <h5>Order #{{ $sale->id }}</h5>
        <p>
            Created at: {{ $sale->created_at->format('d F Y') }} | Due on: {{ $sale->due_date->format('d F Y') }}
        </p>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">X</button>
    </div>
    <div class="modal-body">
        <h6>Ordered Items</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->items as $item)
                <tr>
                    <td>{{ $item->product->nama_barang }}</td>
                    <td>Rp {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h6>Total: Rp {{ number_format($sale->total, 0, ',', '.') }}</h6>
    </div>
    <div class="modal-footer">
        <a href="{{ route('sales.generateInvoice', $sale->id) }}" class="btn btn-primary">Cetak Invoice</a>
        <a href="{{ route('sales.generateSuratJalan', $sale->id) }}" class="btn btn-secondary">Cetak Surat Jalan</a>
        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
</div>
