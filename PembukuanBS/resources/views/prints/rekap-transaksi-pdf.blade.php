{{-- filepath: resources/views/prints/rekap-transaksi-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Rekap Transaksi PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 4px 8px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Rekap Transaksi Bulan {{ $bulan }}/{{ $tahun }}</h2>
    <p>Jenis Rekap: {{ ucfirst($jenisRekap) }}</p>

    @if($jenisRekap === 'setoran' || $jenisRekap === 'semua')
    <h3>Setoran Sampah</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Nasabah</th>
                <th>Tanggal</th>
                <th>Jenis Sampah</th>
                <th>Berat (kg)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($setoranDetails as $detail)
            <tr>
                <td>{{ $detail->user->name ?? '-' }}</td>
                <td>{{ $detail->tanggal_transaksi ? \Carbon\Carbon::parse($detail->tanggal_transaksi)->format('d-m-Y') : '-' }}</td>
                <td>{{ $detail->daftar->nama ?? '-' }}</td>
                <td>{{ $detail->satuan }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($jenisRekap === 'kas' || $jenisRekap === 'semua')
    <h3>Transaksi Kas</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Aksi</th>
                <th>Nominal</th>
                <th>Saldo</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kasRecords as $kas)
            <tr>
                <td>{{ $kas->tanggal }}</td>
                <td>{{ $kas->user->name ?? '-' }}</td>
                <td>{{ ucfirst($kas->aksi) }}</td>
                <td>Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($kas->saldo, 0, ',', '.') }}</td>
                <td>{{ $kas->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>