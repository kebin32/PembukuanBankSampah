<div>
    <flux:modal name="edit-daftar" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit</flux:heading>
                <flux:subheading>Edit daftar harga.</flux:subheading>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama jenis sampah" />
            
            <flux:input wire:model="harga" label="Harga" placeholder="2000" />


            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="update">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>