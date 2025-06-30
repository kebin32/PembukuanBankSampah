<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Rekap Transaksi Bulanan - {{ $bulan }}/{{ $tahun }}</h2>

    <h3>Setoran</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($setoranRecords as $setoran)
                <tr>
                    <td>{{ $setoran->tanggal }}</td>
                    <td>{{ $setoran->nasabah->nama }}</td>
                    <td>Rp{{ number_format($setoran->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Kas</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Aksi</th>
                <th>Nominal</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kasRecords as $kas)
                <tr>
                    <td>{{ $kas->tanggal }}</td>
                    <td>{{ $kas->nasabah->nama }}</td>
                    <td>{{ ucfirst($kas->aksi) }}</td>
                    <td>Rp{{ number_format($kas->jumlah, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($kas->saldo, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
