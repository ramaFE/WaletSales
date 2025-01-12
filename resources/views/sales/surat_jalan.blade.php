<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .no-border { border: none; }
        .header, .footer { width: 100%; text-align: center; }
        .footer { margin-top: 50px; }
        .logo { height: 75px; }
        .kop-table td { padding: 5px; font-size: 12px; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <!-- Header Surat Jalan -->
    <div>
        <table class="no-border" style="width: 100%;">
            <tr>
                <td style="width: 20%;">
                    <img src="{{ asset('logo-eajm.jpg') }}" class="logo">
                </td>
                <td>
                    <div style="text-align: left;">
                        <h4 style="margin: 0; padding: 0;">PT. ENGGAR AJI JAYA MULIA</h4>
                        <p style="margin: 0; padding: 0; font-size: 12px;">
                            Jalan Kehakiman XI No. C-13 Tanah Tinggi, Kota Tangerang, Banten - 15119 <br>
                            Telp: 0821-2212-1913 | Email: info@ptbim.co.id
                        </p>
                    </div>
                </td>
                <td style="text-align: right;">
                    <p><strong>Tanggal:</strong> {{ now()->format('d F Y') }}</p>
                    <p><strong>Kepada:</strong> {{ $customer['name'] }}</p>
                    <p>{{ $customer['address'] }}</p>
                </td>
            </tr>
        </table>
        <h3 style="text-align: center; margin: 0;">SURAT JALAN</h3>
        <p style="text-align: center; margin: 0; margin-bottom: 20px;">No: {{ $delivery_order }}</p>
    </div>

    <!-- Tabel Data Barang -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Berat (gr)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ number_format($item['berat'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <div style="text-align: center; float:left;margin-left:50px">
        Hormat kami,
        <br>
        <br>
        <br>
        <br>
        ______________
    </div>
    <div style="text-align: center; float:right;margin-right:50px">
        Diterima oleh,
        <br>
        <br>
        <br>
        <br>
        ______________
    </div>

</body>
</html>
