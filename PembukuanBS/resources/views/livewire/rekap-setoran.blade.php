<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Setoran Sampah - {{ $monthName }}</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 30px; font-size: 0.8em; border-top: 1px solid #000; padding-top: 5px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekap Setoran Sampah</h2>
        <h3>Periode: {{ $monthName }}</h3>
        <p>Dicetak pada: {{ $printedAt }}</p>
    </div>

    @if(isset($setoranDetails) && $setoranDetails->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Jenis Sampah</th>
                <th class="text-right">Berat (kg)</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($setoranDetails as $index => $setoran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($setoran->tanggal_transaksi)->format('d-m-Y') }}</td>
                <td>{{ $setoran->user->name ?? 'N/A' }}</td>
                <td>{{ $setoran->daftar->nama ?? 'N/A' }}</td>
                <td class="text-right">{{ number_format($setoran->satuan, 2) }}</td>
                <td class="text-right">Rp {{ number_format($setoran->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($setoran->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right bold">Total Setoran:</td>
                <td class="text-right bold">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    @else
    <p class="text-center">Tidak ada data setoran pada periode {{ $monthName }}</p>
    @endif

    <div class="footer">
        <table width="100%">
            <tr>
                <td width="70%"></td>
                <td class="text-center">
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p>(__________________)</p>
                    <p>Manager</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

