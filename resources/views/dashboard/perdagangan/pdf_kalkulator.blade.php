<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #555;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f1f1f1;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Hasil Kalkulator Perdagangan</h2>
    <p>Tanggal: {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah Terjual</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $r)
                <tr>
                    <td>{{ $r['name'] }}</td>
                    <td>{{ $r['quantity'] }}</td>
                    <td>{{ number_format($r['price'], 0, ',', '.') }}</td>
                    <td>{{ number_format($r['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total Keseluruhan</strong></td>
                <td><strong>{{ number_format(array_sum(array_column($results, 'total')), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
