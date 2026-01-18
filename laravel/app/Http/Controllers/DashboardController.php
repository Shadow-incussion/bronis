<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===============================
        // CARD DASHBOARD
        // ===============================
        $totalProduk = Produk::count();

        $stokMenipis = Produk::where('stok', '<=', 5)->count();

        $pesananHariIni = Transaksi::whereDate('created_at', today())->count();

        // 🔥 TOTAL PENJUALAN = LAPORAN
        $totalPenjualan = Laporan::sum('subtotal');

        // ===============================
        // GRAFIK HARIAN (7 HARI)
        // ===============================
        $harian = Laporan::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(subtotal) as total')
            )
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $harianLabel = $harian->pluck('tanggal')
            ->map(fn ($tgl) => date('d M', strtotime($tgl)));

        $harianTotal = $harian->pluck('total');

        // ===============================
        // GRAFIK MINGGUAN
        // ===============================
        $mingguan = Laporan::select(
                DB::raw('WEEK(created_at) as minggu'),
                DB::raw('SUM(subtotal) as total')
            )
            ->groupBy('minggu')
            ->orderBy('minggu')
            ->get();

        $mingguanLabel = $mingguan->pluck('minggu')
            ->map(fn ($m) => 'Minggu ' . $m);

        $mingguanTotal = $mingguan->pluck('total');

        // ===============================
        // GRAFIK BULANAN
        // ===============================
        $bulanan = Laporan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(subtotal) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulananLabel = $bulanan->pluck('bulan')
            ->map(fn ($b) => date('F', mktime(0, 0, 0, $b, 1)));

        $bulananTotal = $bulanan->pluck('total');

        return view('admin.dashboard', compact(
            'totalProduk',
            'stokMenipis',
            'pesananHariIni',
            'totalPenjualan',
            'harianLabel',
            'harianTotal',
            'mingguanLabel',
            'mingguanTotal',
            'bulananLabel',
            'bulananTotal'
        ));
    }
}
