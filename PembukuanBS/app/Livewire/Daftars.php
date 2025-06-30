<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Daftar;
use Livewire\Attributes\On;

use Flux\Flux;

class Daftars extends Component
{
    public $daftars, $daftarId;

    public function mount()
    {
        $this->daftars = Daftar::all();
    }

    public function render()
    {
        return view('livewire.daftars', [
            'daftars' => $this->daftars // Kirim data ke Blade
        ]);
    }

    #[On("reloadDaftars")]
    public function indexreloadDaftars()
    {
        $this->daftars = Daftar::all();
    }
    
    public function edit($id)
    {
        $this->dispatch("editDaftar", $id);
    }

}