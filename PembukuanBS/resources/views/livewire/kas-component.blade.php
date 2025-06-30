<div class="p-6 space-y-4">
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Transaksi Kas</h2>
   
    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" wire:model="tanggal" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
            </div>
           
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Nasabah</label>
                <select wire:model="user_id" class="...">
                    <option value="">Pilih Nasabah</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Aksi</label>
                <select wire:model="aksi" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="">Pilih Aksi</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>
           
            <div>
                <label class="block text-sm font-medium text-gray-700">Nominal</label>
                <input type="number" wire:model="nominal" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
            <textarea wire:model="keterangan" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-md shadow hover:bg-blue-600 transition">Simpan</button>
    </form>

    <h3 class="text-xl font-bold text-gray-700 mt-6">Catatan Kas</h3>
    <div class="overflow-x-auto mt-2">
        <table class="w-full border rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Nasabah</th>
                    <th class="p-2">Aksi</th>
                    <th class="p-2">Nominal</th>
                    <th class="p-2">Saldo</th>
                    <th class="p-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kasRecords as $kas)
                    <tr class="border-t text-gray-600">
                        <td class="p-2">{{ $kas->tanggal }}</td>
                        <td class="p-2">{{ $kas->user->name }}</td>
                        <td class="p-2">{{ ucfirst($kas->aksi) }}</td>
                        <td class="p-2"style="text-align: right !important;">Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                        <td class="p-2"style="text-align: right !important;">Rp {{ number_format($kas->saldo, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $kas->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kasRecords->links() }}
        </div>
    </div>
</div>
