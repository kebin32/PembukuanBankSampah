<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\Attributes\On;
use Flux;
use App\Models\Daftar;

class DaftarEdit extends Component
{
    public $nama, $harga, $daftarid;

    public function render()
    {
        return view('livewire.daftar-edit');
    }

    #[On("editDaftar")]
    public function editDaftar($id)
    {
        $daftar = Daftar::find($id);

        if (!$daftar) {
            session()->flash("error", "Data tidak ditemukan!");
            return;
        }
        $this->daftarid = $daftar->id;
        $this->nama = $daftar->nama;
        $this->harga = $daftar->harga;

        Flux::modal("edit-daftar")->show();

    }

    public function update()
    {
        $this->validate([
            "nama" => "required",
            "harga" => "required|numeric|min:0"
        ]);

        $daftar = Daftar::find($this->daftarid);
        if (!$daftar) {
            session()->flash("error", "Data tidak ditemukan!");
            return;
        }
        $daftar->nama = $this->nama;
        $daftar->harga = $this->harga;
        $daftar->save();

        Flux::modal("edit-daftar")->close();

        $this->dispatch("reloadDaftars");

    }
}