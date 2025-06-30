<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-700 dark:text-white mb-4">Tambah Setoran</h2>

    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label class="block text-gray-600 dark:text-gray-200 text-sm font-semibold mb-1">Nasabah</label>
            <select wire:model="nasabah_id" class="w-full p-2 border border-gray-400 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring focus:ring-blue-300" style="color: inherit;">
                <option value="">Pilih Nasabah</option>
                @foreach($nasabahs as $nasabah)
                    <option value="{{ $nasabah->id }}">{{ $nasabah->name }}</option>
                @endforeach
            </select>
            @error('nasabah_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 dark:text-gray-200 text-sm font-semibold mb-1">Tanggal</label>
            <input type="date" wire:model="tanggal" class="w-full p-2 border border-gray-400 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring focus:ring-blue-300">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase">
                    <tr>
                        <th class="p-2 border">Daftar Harga</th>
                        <th class="p-2 border">Satuan (kg)</th>
                        <th class="p-2 border">Harga</th>
                        <th class="p-2 border">Subtotal</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $index => $detail)
                    <tr>
                        <td class="p-2 border">
                            <select wire:model="details.{{ $index }}.daftar_id" class="w-full p-2 border border-gray-400 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring focus:ring-blue-300">
                                <option value="">Pilih Barang</option>
                                @foreach($daftars as $daftar)
                                    <option value="{{ $daftar->id }}">{{ $daftar->nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-2 border">
                            <input type="number" wire:model="details.{{ $index }}.satuan" min="1" class="w-full p-2 border border-gray-400 dark:border-gray-500 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring focus:ring-blue-300">
                        </td>
                        <td class="p-2 border text-center text-gray-900 dark:text-gray-200">{{ number_format($details[$index]['harga'] ?? 0) }}</td>
                        <td class="p-2 border text-center text-gray-900 dark:text-gray-200">{{ number_format($details[$index]['subtotal'] ?? 0) }}</td>
                        <td class="p-2 border text-center">
                            <button type="button" wire:click="$refresh" class="px-3 py-1 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white rounded transition mr-2">Update</button>    
                            <button type="button" wire:click="removeDetail({{ $index }})" class="px-3 py-1 border border-red-500 text-red-500 hover:bg-red-500 hover:text-white rounded transition">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="button" wire:click="addDetail" class="px-4 py-2 bg-green-500 dark:bg-green-600 text-white rounded-lg hover:bg-green-600 dark:hover:bg-green-700 transition">Tambah Barang</button>
        </div>

        <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <h3 class="text-xl font-semibold text-gray-700 dark:text-white">Total: Rp {{ number_format($total) }}</h3>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full px-4 py-2 bg-blue-500 dark:bg-blue-600 text-white rounded-lg hover:bg-blue-600 dark:hover:bg-blue-700 transition">Simpan</button>
        </div>
        @error('details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </form>

    @if(session()->has('success'))
        <div class="mt-4 p-3 bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300 border border-green-400 dark:border-green-600 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
</div>

