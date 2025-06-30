<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Flux\Flux;

class Nasabahs extends Component
{
    public $nasabahs, $nasabahId;

    public function mount()
    {
        $this->nasabahs = User::where('role', 'nasabah')->get();
    }

    public function render()
    {
        $nasabahs = User::where('role', 'nasabah')->get();

        return view('livewire.nasabahs', compact('nasabahs'));
    }

    #[On("reloadNasabahs")]
    public function indexreloadNasabahs()
    {
        $this->nasabahs = User::where('role', 'nasabah')->get();
    }

    public function edit($id)
    {
        $this->dispatch('editNasabah', id: $id);
    }

    public function delete($id)
    {
        $this->nasabahId = $id;
        Flux::modal("delete-nasabah")->show();
    }

    public function destroy()
    {

        $nasabah = User::where('role', 'nasabah')->find($this->nasabahId);

        if (!$nasabah) {
            session()->flash("error", "Nasabah tidak ditemukan!");
            return;
        }

        $nasabah->delete();

        $this->indexreloadNasabahs();
        Flux::modal("delete-nasabah")->close();
    }

}
