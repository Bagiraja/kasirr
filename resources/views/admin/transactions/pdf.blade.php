<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga per Unit</th>
                <th>Total Harga</th>
                <th>Uang Tunai</th>
                <th>Kembalian</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->product->name }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>Rp{{ number_format($transaction->price, 2) }}</td>
                    <td>Rp{{ number_format($transaction->total, 2) }}</td>
                    <td>Rp{{ number_format($transaction->cash_received, 2) }}</td>
                    <td>Rp{{ number_format($transaction->change, 2) }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
