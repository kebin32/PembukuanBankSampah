<x-layouts.app title="Setoran">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Setoran Anggota</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('list setoran sampah yang terjadi') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <livewire:setoran-create />
</x-layouts.app>