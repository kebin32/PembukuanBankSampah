<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kas;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class KasComponent extends Component
{
    use WithPagination;

    public $tanggal, $user_id, $aksi, $nominal, $saldo, $keterangan;

    public function mount()
    {
        $this->resetForm();
    }

    #[On('kasUpdated')]
    public function loadKasRecords()
    {
        $this->kasRecords = Kas::latest()->get();
    }

    public function updatedUserId()
    {
        $user = \App\Models\User::find($this->user_id);

        if ($user) {
            $this->saldo = $user->saldo ?? 0;
            $this->namaUser = $user->name;
        }
    }

    public function submit()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'aksi' => 'required|in:pemasukan,pengeluaran',
            'nominal' => 'required|numeric|min:1',
        ]);

        $user = User::find($this->user_id);
        $bankSampah = User::find(1);

        if (!$user || !$bankSampah) {
            session()->flash('error', 'Nasabah atau Bank Sampah tidak ditemukan.');
            return;
        }

        // ❌ Pemasukan hanya boleh dilakukan oleh Bank Sampah
        if ($this->aksi === 'pemasukan' && $user->id !== 1) {
            session()->flash('error', 'Pemasukan hanya dapat dilakukan oleh Bank Sampah.');
            return;
        }

        if ($this->aksi === 'pengeluaran') {
            // ✅ Semua user bisa melakukan pengeluaran, termasuk Bank Sampah
            if ($user->saldo < $this->nominal) {
                session()->flash('error', 'Saldo tidak mencukupi! Penarikan melebihi saldo yang tersedia.');
                return;
            }

            // Kurangi saldo user (termasuk jika dia adalah Bank Sampah)
            $user->saldo -= $this->nominal;
            $user->save();

            // Jika yang melakukan pengeluaran BUKAN Bank Sampah, Bank Sampah juga ikut berkurang
            if ($user->id !== 1) {
                if ($bankSampah->saldo < $this->nominal) {
                    session()->flash('error', 'Saldo Bank Sampah tidak mencukupi untuk transaksi ini.');
                    return;
                }
                $bankSampah->saldo -= $this->nominal;
                $bankSampah->save();
            }
        }

        if ($this->aksi === 'pemasukan') {
            $user->saldo += $this->nominal;
            $user->save();
        }

        // Simpan transaksi kas
        Kas::create([
            'tanggal' => $this->tanggal,
            'user_id' => $this->user_id,
            'aksi' => $this->aksi,
            'nominal' => $this->nominal,
            'saldo' => $user->saldo,
            'keterangan' => $this->keterangan,
        ]);

        $this->resetForm();
        $this->resetPage();
        session()->flash('success', 'Transaksi berhasil disimpan.');
    }

    public function resetForm()
    {
        $this->tanggal = now()->toDateString();
        $this->user_id = null;
        $this->aksi = null;
        $this->nominal = null;
        $this->saldo = null;
        $this->keterangan = '';
    }

    public function render()
    {
        return view('livewire.kas-component', [
            'users' => User::all(),
            'kasRecords' => Kas::with('user')->latest()->paginate(5),
        ]);
    }
}
