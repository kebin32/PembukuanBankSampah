<div>
    <livewire:nasabah-edit />

    <flux:modal name="delete-nasabah" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete anggota?</flux:heading>

            <flux:subheading>
                <p>You're about to delete this person.</p>
                <p>This action cannot be reversed.</p>
            </flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger" wire:click="destroy()">Delete anggota</flux:button>
        </div>
    </div>
    </flux:modal>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Role</th>
                    <th scope="col" class="px-6 py-3">Saldo</th>
                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nasabahs as $nasabah)
                <tr class="...">
                    <td class="px-6 py-2">{{ $nasabah->id }}</td>
                    <td class="px-6 py-2">{{ $nasabah->name }}</td>
                    <td class="px-6 py-2">{{ $nasabah->role }}</td>
                    <td class="px-6 py-2" style="text-align: right !important;">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</td>
                    <td class="px-6 py-2">
                        <flux:button size="sm" wire:click="edit({{ $nasabah->id }})">Edit</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="delete({{ $nasabah->id }})">Delete</flux:button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>   
</div>
