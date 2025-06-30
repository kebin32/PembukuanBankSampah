<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Transaksi Kas - {{ $monthName }}</title>
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
        .pemasukan { color: #000; }
        .pengeluaran { color: #000; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Rekap Transaksi Kas</h2>
        <h3>Periode: {{ $monthName }}</h3>
        <p>Dicetak pada: {{ $printedAt }}</p>
    </div>

    @if(isset($kasRecords) && $kasRecords->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Aksi</th>
                <th class="text-right">Nominal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kasRecords as $index => $kas)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $kas->user->name ?? 'N/A' }}</td>
                <td>{{ ucfirst($kas->aksi) }}</td>
                <td class="text-right {{ $kas->aksi === 'pemasukan' ? 'pemasukan' : 'pengeluaran' }}">
                    Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                </td>
                <td>{{ $kas->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right bold">Total Pemasukan:</td>
                <td class="text-right bold pemasukan">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right bold">Total Pengeluaran:</td>
                <td class="text-right bold pengeluaran">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right bold">Saldo Akhir:</td>
                <td class="text-right bold">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    @else
    <p class="text-center">Tidak ada data transaksi kas pada periode {{ $monthName }}</p>
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