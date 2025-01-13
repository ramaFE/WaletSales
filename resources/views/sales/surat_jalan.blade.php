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
                <td style = "text-align: center">
                    <img class="img-profile rounded-circle" 
                    src="{{ public_path('logo-eajm.jpg') }}" 
                    alt="Logo EAJM"
                    style="width: 100px; height: 85px;">
                </td>
                <td style="text-align: center;">
                    <h3>PT.ENGGAR AJI JAYA MULIA</h3>
                    <p>Jl. Karang Bendo No.43B, Karangrejo, Kec. Gajahmungkur, Kota Semarang, Jawa Tengah 50231</p>
                    <p>Telp: 0811-2729-000 | Email: pt.eajm@gmail.com</p>
                </td>
                <td style="text-align: right;">
                    <p><strong>Tanggal:</strong> {{ now()->format('d F Y') }}</p>
                    <p><strong>Kepada:</strong> {{ $customer['name'] }}</p>
                    <p>{{ $customer['address'] }}</p>
                </td>
            </tr>
        </table>
        <h3 style="text-align: center; margin: 0;">SURAT JALAN</h3>
        <p style="text-align: center; margin: 0; margin-bottom: 20px;">No: {{ $sale->delivery_order }}</p>
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
            @foreach ($sale->items as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>{{ number_format($item->berat, 0, ',', '.') }}</td>
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
