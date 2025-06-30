<div>
    <flux:modal.trigger name="create-daftar">
        <flux:button>Tambah jenis sampah</flux:button>
    </flux:modal.trigger>
    
    <livewire:daftar-create />
    <livewire:daftar-edit />
    

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3 text-right">Harga/(Satuan)Kg</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftars as $daftar)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="text-center px-6 py-2 font-medium text-gray-900 dark:text-white">{{ $daftar->id }}</td>
                    <td class="text-center px-6 py-2 text-gray-600 dark:text-gray-300">{{ $daftar->nama }}</td>
                    <td class="px-6 py-2 text-gray-600 dark:text-gray-300" style="text-align: right !important;"> Rp {{ number_format($daftar->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-2 text-center">
                        <flux:button size="sm" wire:click="edit({{ $daftar->id }})">Edit</flux:button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>   
</div>
