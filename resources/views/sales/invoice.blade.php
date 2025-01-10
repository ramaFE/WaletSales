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
        .no-border { border: none; }
        .kop-table { border: none; width: 100%; margin-bottom: 20px; }
        .kop-table td { padding: 5px; }
        .font-semibold { font-weight: bold; }
        .header-title { text-align: center; font-size: 1.5em; font-weight: bold; }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div style="width:100%;position:relative;border-bottom:2px solid black; padding-bottom:1.5em;">
        <table cellspacing="0" cellpadding="5" style="width:150px;position:absolute;right:0;top:.5em;">
            <tbody>
                <tr>
                    <td class="font-semibold" colspan="2" style="text-align: center;">INVOICE</td>
                </tr>
                <tr>
                    <td class="font-semibold" style="text-align: center;">No:</td>
                    <td style="text-align: right;">{{ $order["order_number"] }}</td>
                </tr>
            </tbody>
        </table>
        <table cellspacing="0" style="position:relative;top:0;">
            <tbody>
                <tr>
                    <td rowspan="4" style="padding: 0 1em 0 0">
                        <img src="{{ url('sb/img/logo-eajm.jpg') }}" style="height: 75px;">
                    </td>
                    <td class="font-semibold">
                        <h3 style="padding: 0;margin:0;">PT. ENGGAR AJI JAYA MULIA</h3>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: .9em">Jalan Kehakiman XI No. C-13 Tanah Tinggi</td>
                </tr>
                <tr>
                    <td style="font-size: .9em">Kota Tangerang, Banten - 15119</td>
                </tr>
                <tr>
                    <td style="font-size: .9em">Telp: 0821-2212-1913 Email: info@ptbim.co.id Website: www.ptbim.co.id</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Detail Customer -->
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin-top: 20px;">
        <tbody>
            <tr>
                <td><strong>Customer Name:</strong></td>
                <td class="font-semibold">{{ $order["customer"]["name"] }}</td>
                <td><strong>PO NO:</strong></td>
                <td class="font-semibold">{{ $order["delivery_order"] }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td colspan="3" class="font-semibold">{{ $order["customer"]["address"] }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td class="font-semibold">{{ now()->format('d F Y') }}</td>
                <td><strong>Contact:</strong></td>
                <td class="font-semibold">{{ $order["customer"]["contact"] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Daftar Barang -->
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; margin-top: 20px;">
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

    <div style="text-align: right; margin-top: 20px;">
        <p>Tangerang, {{ now()->format('d F Y') }}</p>
    </div>
</body>
</html>
