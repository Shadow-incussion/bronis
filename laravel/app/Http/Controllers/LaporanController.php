<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->periode ?? 'harian';

        if ($periode == 'mingguan') {
            $laporan = Laporan::select(
                    DB::raw('YEARWEEK(created_at) as tanggal'),
                    DB::raw('SUM(subtotal) as total_penjualan')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'desc')
                ->get();
        }
        elseif ($periode == 'bulanan') {
            $laporan = Laporan::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as tanggal'),
                    DB::raw('SUM(subtotal) as total_penjualan')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'desc')
                ->get();
        }
        else {
            // HARIAN (DEFAULT)
            $laporan = Laporan::select(
                    DB::raw('DATE(created_at) as tanggal'),
                    DB::raw('SUM(subtotal) as total_penjualan')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        $totalKeseluruhan = $laporan->sum('total_penjualan');

        return view('admin.laporan', compact('laporan', 'totalKeseluruhan'));
    }
}
