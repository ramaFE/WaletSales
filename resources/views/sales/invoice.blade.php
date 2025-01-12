<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .font-semibold { font-weight: bold; }
        .header-title { text-align: center; font-size: 1.5em; font-weight: bold; }
    </style>
</head>
<body>
    <!-- Header Invoice -->
    <div style="border-bottom: 2px solid black; margin-bottom: 20px;">
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td>
                    <img src="{{ asset('logo-eajm.jpg') }}" style="height: 75px;">
                </td>
                <td style="text-align: center;">
                    <h3>PT. ENGGAR AJI JAYA MULIA</h3>
                    <p>Jalan Kehakiman XI No. C-13 Tanah Tinggi, Kota Tangerang, Banten - 15119</p>
                    <p>Telp: 0821-2212-1913 | Email: info@ptbim.co.id</p>
                </td>
                <td style="text-align: center;">
                    <h4>INVOICE</h4>
                    <p>No: {{ $order['order_number'] }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Customer Details -->
    <table>
        <tr>
            <td><strong>Customer Name:</strong></td>
            <td>{{ $order['customer']['name'] }}</td>
            <td><strong>PO No:</strong></td>
            <td>{{ $order['delivery_order'] }}</td>
        </tr>
    </table>

    <!-- Daftar Barang -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Berat (gr)</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order['items'] as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['kode_produk'] }}</td>
                    <td>{{ $item['nama_barang'] }}</td>
                    <td>{{ number_format($item['berat'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Subtotal</strong></td>
                <td><strong>Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    <div style="margin-top:2.5em">
        <div style="float:right">Semarang, {{ now()->format('d F Y') }}</div>
        <div class="font-semibold">
            <div>Please remit your payment in full amount to our bank</div>
            <div>Bank BCA</div>
            <div>Account no: 155-00-1077967-9</div>
            <div>Account name: ENGGARWATI JANURITA</div>
        </div>
    </div>
</body>
</html>
