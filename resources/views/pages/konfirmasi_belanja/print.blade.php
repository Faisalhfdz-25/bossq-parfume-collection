<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .list-belanja {
            margin-bottom: 20px;
        }

        .list-belanja h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>TOKO BOSSQ PARFUME COLLECTION</h1>
            <p>Alamat Toko | Nomor Telepon</p>
        </div>
        <div class="list-belanja">
            <h2>Informasi List Belanja</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total Items</th>
                        <th>Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $listBelanja->kode }}</td>
                        <td>{{ $listBelanja->tanggal }}</td>
                        <td>{{ $listBelanja->total_items }}</td>
                        <td>{{ $listBelanja->total_payment }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="detail-list-belanja">
            <h2>Detail List Belanja</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Tempat</th>
                        <th>Sub Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>{{ $detail->products->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->harga }}</td>
                            <td>{{ $detail->tempat }}</td>
                            <td>{{ $detail->sub_total }}</td>
                            <td>
                                @if ($detail->acc === 1)
                                    Di Setujui
                                @elseif ($detail->acc === 0)
                                    Tidak Disetujui
                                @else
                                    Belum Disetujui
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
