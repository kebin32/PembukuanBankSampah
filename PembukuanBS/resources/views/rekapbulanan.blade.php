<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Rekap Transaksi Bulanan</h2>
    
    <div class="flex space-x-4 mb-4">
        <select wire:model="bulan" class="border rounded p-2">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">Bulan {{ $i }}</option>
            @endfor
        </select>
        
        <select wire:model="tahun" class="border rounded p-2">
            @for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                <option value="{{ $i }}">Tahun {{ $i }}</option>
            @endfor
        </select>
    </div>
    
    <h3 class="text-lg font-semibold mb-2">Setoran</h3>
    <table class="w-full border-collapse border border-gray-300 mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Nasabah</th>
                <th class="border p-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($setoranRecords as $setoran)
                <tr>
                    <td class="border p-2">{{ $setoran->tanggal }}</td>
                    <td class="border p-2">{{ $setoran->nasabah->nama }}</td>
                    <td class="border p-2">Rp{{ number_format($setoran->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3 class="text-lg font-semibold mb-2">Kas</h3>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Nasabah</th>
                <th class="border p-2">Aksi</th>
                <th class="border p-2">Nominal</th>
                <th class="border p-2">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kasRecords as $kas)
                <tr>
                    <td class="border p-2">{{ $kas->tanggal }}</td>
                    <td class="border p-2">{{ $kas->nasabah->nama }}</td>
                    <td class="border p-2">{{ ucfirst($kas->aksi) }}</td>
                    <td class="border p-2">Rp{{ number_format($kas->jumlah, 2, ',', '.') }}</td>
                    <td class="border p-2">Rp{{ number_format($kas->saldo, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <button wire:click="exportPDF" class="mt-4 bg-blue-500 text-white p-2 rounded">Export PDF</button>
</div>

