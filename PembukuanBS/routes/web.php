<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\PrintController;
use App\Livewire\RekapTransaksi;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');;

Route::view('nasabah', 'nasabah')
    ->middleware(['auth', 'verified'])
    ->name('nasabah');

Route::view('daftar', 'daftar')
    ->middleware(['auth', 'verified'])
    ->name('daftar');

Route::view('setoran', 'setoran')
    ->middleware(['auth', 'verified'])
    ->name('setoran');

Route::get('/setoran-saya', [SetoranController::class, 'nasabahDetail'])
    ->middleware(['auth', 'verified'])
    ->name('nasabah-detail');

Route::get('rekap', RekapTransaksi::class)
    ->middleware(['auth', 'verified'])
    ->name('rekap');

Route::get('/rekap/print/pdf', [\App\Http\Controllers\RekapController::class, 'printPdf'])->name('rekap.print.pdf');

Route::view('kas', 'kas')
    ->middleware(['auth', 'verified'])
    ->name('kas');
    
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
