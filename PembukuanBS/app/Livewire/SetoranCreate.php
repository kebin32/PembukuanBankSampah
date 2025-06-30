<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\SetoranDetail;
use App\Models\Daftar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SetoranCreate extends Component
{
    public $nasabah_id, $tanggal, $total = 0;
    public $details = [];

    public function mount()
    {
        $this->tanggal = Carbon::now();
        $this->details[] = ['daftar_id' => '', 'satuan' => 1, 'harga' => 0, 'subtotal' => 0];
    }

    public function addDetail()
    {
        $this->details[] = ['daftar_id' => '', 'satuan' => 1, 'harga' => 0, 'subtotal' => 0];
    }

    public function removeDetail($index)
    {
        unset($this->details[$index]);
        $this->details = array_values($this->details);
    }

    public function updatedDetails()
    {
        $this->total = 0;
        foreach ($this->details as &$detail) {
            if ($detail['daftar_id']) {
                $harga = Daftar::find($detail['daftar_id'])->harga;
                $detail['harga'] = $harga;
                $detail['subtotal'] = $harga * $detail['satuan'];
                $this->total += $detail['subtotal'];
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'nasabah_id' => 'required|exists:users,id',
            'details' => 'required|array|min:1',
            'details.*.daftar_id' => 'required|exists:daftars,id',
            'details.*.satuan' => 'required|numeric|min:1',
        ]);

        // Get nasabah and verify role
        $nasabah = User::where('id', $this->nasabah_id)
                      ->where('role', 'nasabah')
                      ->first();

        if (!$nasabah) {
            session()->flash('error', 'Invalid nasabah selected.');
            return;
        }

        // Get admin user
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            session()->flash('error', 'Admin user not found.');
            return;
        }

        // Use database transaction to ensure all updates succeed or all fail
        DB::beginTransaction();
        
        try {
            foreach ($this->details as $detail) {
                SetoranDetail::create([
                    'user_id' => $nasabah->id,
                    'nama' => $nasabah->name,
                    'daftar_id' => $detail['daftar_id'],
                    'satuan' => $detail['satuan'],
                    'harga' => $detail['harga'],
                    'subtotal' => $detail['subtotal'],
                    'total' => $this->total,
                    'tanggal_transaksi' => $this->tanggal,
                ]);
            }

            // Update both nasabah and admin saldo
            $nasabah->saldo += $this->total;
            $nasabah->save();

            $admin->saldo += $this->total;
            $admin->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Error processing deposit: ' . $e->getMessage());
            return;
        }

        session()->flash('success', 'Setoran berhasil disimpan.');
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nasabah_id = null;
        $this->details = [['daftar_id' => '', 'satuan' => 1, 'harga' => 0, 'subtotal' => 0]];
        $this->total = 0;
        $this->tanggal = Carbon::now();
    }

    public function render()
    {
        return view('livewire.setoran-create', [
            'nasabahs' => User::where('role', 'nasabah')
                             ->where('id', '!=', auth()->id()) // Exclude admin/current user
                             ->get(),
            'daftars' => Daftar::all(),
        ]);
    }
}

