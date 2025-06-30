<div>
    <flux:modal name="create-daftar" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Sampah</flux:heading>
                <flux:subheading>Tambah jenis sampah baru.</flux:subheading>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama jenis sampah baru" />
            @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <flux:input wire:model="harga" label="Harga" placeholder="100000" />
            @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror



            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="submit">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>