<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SetoranDetail;
use App\Models\Kas;
use Carbon\Carbon;

class RekapTransaksi extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;
    public $jenisRekap = 'setoran';
    public $showPrintView = false;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $startDate = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $setoranDetails = [];
        $kasRecords = [];
        $totalSetoran = 0;
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $saldoAkhir = 0;

        if ($this->jenisRekap === 'setoran' || $this->jenisRekap === 'semua') {
            $setoranDetails = SetoranDetail::with(['user', 'daftar'])
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->paginate(10, ['*'], 'setoran_page');
            
            $totalSetoran = SetoranDetail::whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->sum('subtotal');
        }

        if ($this->jenisRekap === 'kas' || $this->jenisRekap === 'semua') {
            $kasRecords = Kas::with('user')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->paginate(10, ['*'], 'kas_page');
            
            $totalPemasukan = Kas::where('aksi', 'pemasukan')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('nominal');
            
            $totalPengeluaran = Kas::where('aksi', 'pengeluaran')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('nominal');
            
            $lastKas = Kas::where('tanggal', '<=', $endDate)
                ->orderBy('tanggal', 'desc')
                ->first();
            
            $saldoAkhir = $lastKas ? $lastKas->saldo : 0;
        }

        $bulanOptions = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanOptions[$i] = Carbon::create()->month($i)->monthName;
        }

        $tahunOptions = range(date('Y') - 2, date('Y') + 1);

        return view('livewire.rekap-transaksi', compact(
            'setoranDetails',
            'kasRecords',
            'totalSetoran',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'bulanOptions',
            'tahunOptions',
            'startDate'
        ));
    }

    public function print()
    {
        $this->showPrintView = true;
    }
}