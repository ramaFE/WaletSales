<div class="container">
    <h5>Order #{{ $sale['no'] }}</h5>
    <p>Delivery Order: {{ $sale['delivery_order'] }}</p>
    <p>Customer: {{ $sale['customer'] }}</p>
    <p>Address: {{ $sale['address'] }}</p>

    <h6>Items Ordered</h6>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Berat</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale['items'] as $item)
            <tr>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ number_format($item['berat'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h6>Total</h6>
    <p><strong>Rp{{ $sale['total'] }}</strong></p>
</div>
