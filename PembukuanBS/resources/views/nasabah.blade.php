<x-layouts.app title="Nasabah">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Nasabah</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Atur akun anggota bank sampah') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <livewire:nasabahs />
</x-layouts.app>