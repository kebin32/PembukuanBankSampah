<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Flux;

class NasabahEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $saldo;
    protected $listeners = ['editNasabah' => 'edit'];

    public function render()
    {
        return view('livewire.nasabah-edit');
    }

    #[On("editNasabah")]
    public function edit($id)
    {
        $user = User::where('role', 'nasabah')->findOrFail($id);

        $this->userId = $user->id;
        $this->name   = $user->name;
        $this->email  = $user->email;
        $this->saldo  = $user->saldo;

        Flux::modal('edit-nasabah')->show();
    }

    public function update()
    {
        $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'saldo' => 'required|numeric|min:0',
        ]);

        $user = User::where('role', 'nasabah')->findOrFail($this->userId);

        $user->update([
            'name'  => $this->name,
            'email' => $this->email,
            'saldo' => $this->saldo,
        ]);

        Flux::modal('edit-nasabah')->close();
        $this->dispatch('reloadNasabahs');
    }

    public function delete($id)
    {
        $user = User::where('role', 'nasabah')->findOrFail($id);
        $user->delete();

        Flux::modal('delete-nasabah')->close();
        $this->dispatch('reloadNasabahs');
    }
}
