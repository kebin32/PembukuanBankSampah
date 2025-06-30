<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use App\Models\SetoranDetail;
use Illuminate\Support\Facades\Auth;

class NasabahDetail extends Component
{
    use WithPagination;
    public $user_id = null;

    public function render()
    {
        // Ambil user dengan role nasabah
        $users = User::where('role', 'nasabah')->get();

       // Selalu gunakan paginate, walaupun user_id null
        $setoranDetails = \App\Models\SetoranDetail::with('daftar')
            ->when($this->user_id, function($query) {
                $query->where('user_id', $this->user_id);
            })
            ->latest()
            ->paginate(10);


        return view('livewire.nasabah-detail', [
            'users' => $users,
            'setoranDetails' => $setoranDetails,
        ]);
    }
    
}
