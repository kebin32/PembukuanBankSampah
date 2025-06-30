<?php

namespace App\Livewire;

use App\Models\Daftar;
use Livewire\Component;
use Flux;


class DaftarCreate extends Component
{
    public $nama, $harga;

    public function render()
    {
        return view('livewire.daftar-create');
    }
    
    public function submit()
    {
        $this->validate([
            "nama" => "required|string|max:255",
            "harga" => "required|numeric|min:0",
        ]);

        Daftar::create([
            "nama" => $this->nama,
            "harga" => $this->harga,
        ]);
        
        $this->resetForm();

        Flux::modal("create-daftar")->close();

        $this->dispatch("reloadDaftars");
    }

    public function resetForm()
    {
        $this->nama ="";
        $this->harga ="";
    }
}