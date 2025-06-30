<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setoran;
use App\Models\Kas;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapCreate extends Component
{
    public $bulan, $tahun;
    public $setoranRecords = [], $kasRecords = [];

    public function mount()
    {
        $this->bulan = now('m'); 
        $this->tahun = now('Y'); 
        $this->loadSetoranRecords(); 
        $this->loadKasRecords(); 
    }

    public function loadKasRecords()
    {
        $this->kasRecords = Kas::with('nasabah')
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    public function loadSetoranRecords()
    {
        $this->setoranRecords = Setoran::with(['nasabah', 'details.harga'])
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    public function updatedBulan()
    {
        $this->loadSetoranRecords(); 
        $this->loadKasRecords(); 
    }

    public function updatedTahun()
    {
        $this->loadSetoranRecords();
        $this->loadKasRecords(); 
    }

    public function exportPDF()
    {
        $data = [
            'setoranRecords' => $this->setoranRecords,
            'kasRecords' => $this->kasRecords,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ];

        $pdf = Pdf::loadView('exports.rekap-bulanan', $data);
        return response()->streamDownload(fn () => print($pdf->output()), "Rekap_Bulanan_{$this->bulan}_{$this->tahun}.pdf");
    }

    public function render()
    {
        return view('livewire.rekap-create', [
            'setoranRecords' => $this->setoranRecords,
            'kasRecords' => $this->kasRecords,
        ]);
    }
}

