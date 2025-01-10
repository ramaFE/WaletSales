<div class="container">
    <div class="modal-header">
        <h5>Order #{{ $sale['no'] }}</h5>
        <p>
            Created at: {{ $sale['created_at'] }} | Due on: {{ $sale['due_date'] }}
        </p>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" >X</button>
    </div>
    <div class="modal-body">
        <!-- Ordered Items -->
        <h6>Ordered Items</h6>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale['items'] as $item)
                <tr>
                    <td>{{ $item['kode_produk'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ number_format($item['berat'], 0, ',', '.') }} g</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Sub-total -->
        <table class="table">
            <tr>
                <td>Total</td>
                <td class="text-end"><strong>Rp {{ number_format($sale['total'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        {{--  <!-- Customer Details -->
        <h6>Customer Details</h6>
        <table class="table">
            <tr>
                <td>Nama</td>
                <td>{{ $sale['customer'] }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>{{ $sale['address'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $sale['email'] }}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>{{ $sale['phone'] }}</td>
            </tr>
        </table>  --}}
    </div>
    <div class="modal-footer">
        <a href="{{ route('sales.generateInvoice', ['id' => $sale['no']]) }}" class="btn btn-primary">Cetak Invoice</a>
        <a href="{{ route('sales.generatesurat_jalan', ['id' => $sale['no']]) }}" class="btn btn-secondary">Cetak Surat Jalan</a>
        <button class="btn btn-danger" onclick="deleteOrder({{ $sale['no'] }})">Delete</button>
    </div>
    <script>
        function deleteOrder(id) {
            if (confirm('Apakah Anda yakin ingin menghapus order ini?')) {
                fetch(`/sales/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload(); // Refresh halaman setelah penghapusan
                    } else {
                        alert('Gagal menghapus order.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus order.');
                });
            }
        }
    </script>
</div>
