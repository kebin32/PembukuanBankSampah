<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetoranDetail;
use App\Models\Kas;
use Carbon\Carbon;
use PDF;

class RekapController extends Controller
{
    public function rekap(Request $request, $type)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'monthName' => $startDate->format('F Y'),
            'printedAt' => now()->format('d-m-Y H:i')
        ];
        
        if ($type === 'setoran') {
            $data['setoranDetails'] = SetoranDetail::with(['user', 'daftar'])
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->get();
                
            $data['totalSetoran'] = $data['setoranDetails']->sum('subtotal');
            
            return view('prints.rekap-setoran', $data);
        }
        
        if ($type === 'kas') {
            $data['kasRecords'] = Kas::with('user')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
                
            $data['totalPemasukan'] = $data['kasRecords']->where('aksi', 'pemasukan')->sum('nominal');
            $data['totalPengeluaran'] = $data['kasRecords']->where('aksi', 'pengeluaran')->sum('nominal');
            
            $lastKas = Kas::where('tanggal', '<=', $endDate)
                ->orderBy('tanggal', 'desc')
                ->first();
            
            $data['saldoAkhir'] = $lastKas ? $lastKas->saldo : 0;
            
            return view('prints.rekap-kas', $data);
        }
        
        abort(404);
    }

    public function printPdf(Request $request)
    {
        $bulan = $request->input('month');
        $tahun = $request->input('year');
        $jenisRekap = $request->input('jenisRekap', 'semua');

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $setoranDetails = collect();
        $kasRecords = collect();
        $totalSetoran = 0;
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $saldoAkhir = 0;

        if ($jenisRekap === 'setoran' || $jenisRekap === 'semua') {
            $setoranDetails = SetoranDetail::with(['user', 'daftar'])
                ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                ->get();
            $totalSetoran = $setoranDetails->sum('subtotal');
        }

        if ($jenisRekap === 'kas' || $jenisRekap === 'semua') {
            $kasRecords = Kas::with('user')
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get();
            $totalPemasukan = $kasRecords->where('aksi', 'pemasukan')->sum('nominal');
            $totalPengeluaran = $kasRecords->where('aksi', 'pengeluaran')->sum('nominal');
            $lastKas = Kas::where('tanggal', '<=', $endDate)->orderBy('tanggal', 'desc')->first();
            $saldoAkhir = $lastKas ? $lastKas->saldo : 0;
        }

        $pdf = PDF::loadView('prints.rekap-transaksi-pdf', [
            'setoranDetails' => $setoranDetails,
            'kasRecords' => $kasRecords,
            'totalSetoran' => $totalSetoran,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,
            'startDate' => $startDate,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jenisRekap' => $jenisRekap,
        ]);
        return $pdf->download('rekap-transaksi-'.$bulan.'-'.$tahun.'.pdf');
    }
}
