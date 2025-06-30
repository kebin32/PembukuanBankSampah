
<div class="p-6 space-y-4">
    <div class="mb-4">
        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Nasabah</label>
        <select wire:model="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            <option value="">-- Pilih Nasabah --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <button wire:click="$refresh" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
        Update Data
    </button>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border rounded-md shadow-sm">
            <thead class="bg-gray-100">
                <tr class="text-left text-gray-700">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Jenis Sampah</th>
                    <th class="p-2">Harga/kg</th>
                    <th class="p-2">Berat (kg)</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse ($setoranDetails as $detail)
                    <tr class="border-t">
                        <td class="p-2">{{ $detail->created_at->format('d-m-Y H:i:s') }}</td>
                        <td class="p-2">{{ $detail->daftar->nama ?? '-' }}</td>
                        <td class="p-2">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $detail->satuan }}</td>
                        <td class="p-2" style="text-align: right !important;"">Rp {{ number_format($detail->total, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-4">Tidak ada data setoran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $setoranDetails->links() }}
    </div>
</div>

