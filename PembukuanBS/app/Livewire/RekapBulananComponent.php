<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setoran;
use App\Models\Kas;
use Carbon\Carbon;

class RekapBulananComponent extends Component
{
    public $bulan, $tahun;
    public $setoranRecords, $kasRecords;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->loadRecords();
    }

    public function loadRecords()
    {
        $startDate = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
        $endDate = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth();

        $this->setoranRecords = Setoran::whereBetween('tanggal', [$startDate, $endDate])->get();
        $this->kasRecords = Kas::whereBetween('tanggal', [$startDate, $endDate])->get();
    }

    public function updatedBulan()
    {
        $this->loadRecords();
    }

    public function updatedTahun()
    {
        $this->loadRecords();
    }

    public function exportPDF()
    {
        return redirect()->route('rekap.pdf', ['bulan' => $this->bulan, 'tahun' => $this->tahun]);
    }

    public function render()
    {
        return view('livewire.rekap-bulanan', [
            'setoranRecords' => $this->setoranRecords,
            'kasRecords' => $this->kasRecords,
        ]);
    }
}
