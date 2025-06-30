<div>
    <flux:modal name="edit-nasabah" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Edit</flux:heading>
                <flux:subheading>Edit anggota nasabah.</flux:subheading>
            </div>

            <flux:input wire:model="name" label="Nama" placeholder="Nama anggota" />
            <flux:input wire:model="saldo" label="Saldo" placeholder="100000" />


            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" wire:click="update">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
