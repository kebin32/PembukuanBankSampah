<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetoranDetail;
use App\Models\Kas;
use Carbon\Carbon;

class PrintController extends Controller
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
}