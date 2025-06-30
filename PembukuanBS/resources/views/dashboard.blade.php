<x-layouts.app title="Dashboard">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            
            <!-- Kartu Saldo Bank Sampah -->
            <div class="p-4 bg-white rounded shadow dark:bg-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Selamat datang, {{ auth()->user()->name }}!
                </h2>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Role: <strong class="text-gray-800 dark:text-gray-100">{{ auth()->user()->role }}</strong>
                </p>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Saldo: <strong class="text-gray-800 dark:text-gray-100">Rp {{ number_format(auth()->user()->saldo, 0, ',', '.') }}</strong>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>

