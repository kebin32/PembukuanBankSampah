<div class="p-6 space-y-6">
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Rekap Transaksi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Bulan</label>
                <select wire:model="bulan" class="w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($bulanOptions as $key => $name)
                        <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Tahun</label>
                <select wire:model="tahun" class="w-full border-gray-300 rounded-md shadow-sm">
                    @foreach($tahunOptions as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Rekap</label>
                <select wire:model="jenisRekap" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="semua">Semua Data</option>
                    <option value="setoran">Setoran Sampah</option>
                    <option value="kas">Transaksi Kas</option>
                </select>
            </div>
            <div>
                <button type="button" wire:click="$refresh" class="px-3 py-1 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded transition mr-2">Preview Data</button>
            </div>
            
            <div class="flex items-end">
                <a href="{{ route('rekap.print.pdf', [
                        'month' => $bulan,
                        'year' => $tahun,
                        'jenisRekap' => $jenisRekap
                    ]) }}" 
                    target="_blank"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 block text-center">
                    Cetak Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Setoran Sampah Section -->
    @if(($jenisRekap === 'setoran' || $jenisRekap === 'semua') && count($setoranDetails) > 0)
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-3">Rekap Setoran Sampah</h3>
        <p class="text-sm text-gray-600 mb-4">
            Periode: {{ $startDate->format('F Y') }}
        </p>
        
        <div class="overflow-x-auto">
            <table class="w-full border rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Nasabah</th>
                        <th class="p-2">Jenis Sampah</th>
                        <th class="p-2">Berat (kg)</th>
                        <th class="p-2">Harga</th>
                        <th class="p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($setoranDetails as $setoran)
                    <tr class="border-t text-gray-600">
                        <td class="p-2">{{ $setoran->tanggal_transaksi ? $setoran->tanggal_transaksi->format('d-m-Y') : '' }}</td>
                        <td class="p-2">{{ $setoran->user->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $setoran->daftar->nama ?? 'N/A' }}</td>
                        <td class="p-2 text-right">{{ number_format($setoran->satuan, 2) }}</td>
                        <td class="p-2 text-right">Rp {{ number_format($setoran->harga, 0, ',', '.') }}</td>
                        <td class="p-2 text-right">Rp {{ number_format($setoran->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="5" class="p-2 text-right">Total Setoran:</td>
                        <td class="p-2 text-right">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mt-4">
            {{ $setoranDetails->links('livewire::simple-tailwind', ['pageName' => 'setoran_page']) }}
        </div>
    </div>
    @endif

    <!-- Transaksi Kas Section -->
    @if(($jenisRekap === 'kas' || $jenisRekap === 'semua') && count($kasRecords) > 0)
    <div class="bg-white p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-3">Rekap Transaksi Kas</h3>
        <p class="text-sm text-gray-600 mb-4">
            Periode: {{ $startDate->format('F Y') }}
        </p>
        
        <div class="overflow-x-auto">
            <table class="w-full border rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Nasabah</th>
                        <th class="p-2">Aksi</th>
                        <th class="p-2">Nominal</th>
                        <th class="p-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kasRecords as $kas)
                    <tr class="border-t text-gray-600">
                        <td class="p-2">{{ $kas->tanggal->format('d-m-Y') }}</td>
                        <td class="p-2">{{ $kas->user->name ?? 'N/A' }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $kas->aksi === 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($kas->aksi) }}
                            </span>
                        </td>
                        <td class="p-2 text-right">Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $kas->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="p-2 text-right">Total Pemasukan:</td>
                        <td class="p-2 text-right text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="p-2 text-right">Total Pengeluaran:</td>
                        <td class="p-2 text-right text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="p-2 text-right">Saldo Akhir:</td>
                        <td class="p-2 text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="mt-4">
            {{ $kasRecords->links('livewire::simple-tailwind', ['pageName' => 'kas_page']) }}
        </div>
    </div>
    @endif

    <!-- Empty State -->
    @if(
        ($jenisRekap === 'setoran' && count($setoranDetails) === 0) ||
        ($jenisRekap === 'kas' && count($kasRecords) === 0) ||
        ($jenisRekap === 'semua' && count($setoranDetails) === 0 && count($kasRecords) === 0)
    )
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-blue-500" ...>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="text-xl font-bold mt-4">Tidak Ada Data</h3>
        <p class="text-gray-600 mt-2">
            Tidak ditemukan data transaksi untuk periode {{ $startDate->format('F Y') }}
        </p>
    </div>
    @endif

    <!-- Print View -->
    @if($showPrintView)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-4 border w-full max-w-4xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center pb-3">
                <a href="{{ route('rekap.print.pdf', [
                    'month' => $bulan,
                    'year' => $tahun,
                    'jenisRekap' => $jenisRekap
                ]) }}" target="_blank" ...>Cetak Laporan</a>
                <button wire:click="$set('showPrintView', false)" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif
</div>