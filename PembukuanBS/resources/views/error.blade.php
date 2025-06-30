<x-layouts.app title="403">
    <div class="text-center mt-10">
        <h1 class="text-4xl font-bold text-red-600">403 - Akses Ditolak</h1>
        <p class="mt-4 text-gray-700">Halaman hanya bisa diakses oleh admin.</p>
        <a href="{{ route('dashboard') }}" class="text-blue-500 underline mt-4 block">Kembali ke Dashboard</a>
    </div>
</x-layouts.app>
