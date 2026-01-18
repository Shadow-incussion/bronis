<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Produk;
use App\Models\Laporan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // ===============================
    // HALAMAN TRANSAKSI
    // ===============================
    public function index()
    {
        $transaksi = Transaksi::with(['detail.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        $produk = Produk::with('stok')->get();

        return view('admin.transaksi', compact('transaksi', 'produk'));
    }

    // ===============================
    // SIMPAN TRANSAKSI BARU
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string',
            'produk_id'     => 'required|exists:produk,id',
            'jumlah'        => 'required|integer|min:1',
            'status'        => 'required|in:menunggu,diproses'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $produk = Produk::findOrFail($request->produk_id);
                $stok   = Stok::where('produk_id', $produk->id)->lockForUpdate()->first();

                if (!$stok || $stok->jumlah < $request->jumlah) {
                    throw new \Exception('Stok tidak mencukupi');
                }

                $subtotal = $produk->harga * $request->jumlah;

                // 1️⃣ SIMPAN TRANSAKSI
                $transaksi = Transaksi::create([
                    'nama_customer' => $request->nama_customer,
                    'tanggal'       => now(),
                    'status'        => $request->status,
                    'user_id'       => Auth::id(),
                    'total'         => $subtotal
                ]);

                // 2️⃣ DETAIL TRANSAKSI
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produk->id,
                    'qty'          => $request->jumlah,
                    'harga'        => $produk->harga,
                    'subtotal'     => $subtotal
                ]);

                // 3️⃣ LAPORAN
                Laporan::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id'    => $produk->id,
                    'qty'          => $request->jumlah,
                    'harga'        => $produk->harga,
                    'subtotal'     => $subtotal
                ]);

                // 4️⃣ KURANGI STOK JIKA LANGSUNG DIPROSES
                if ($request->status === 'diproses') {
                    $stok->decrement('jumlah', $request->jumlah);
                }
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi berhasil ditambahkan');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // ===============================
    // UPDATE STATUS TRANSAKSI
    // ===============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {

                $transaksi = Transaksi::with('detail')->lockForUpdate()->findOrFail($id);

                // dari menunggu → diproses
                if ($transaksi->status !== 'diproses' && $request->status === 'diproses') {

                    foreach ($transaksi->detail as $d) {

                        $stok = Stok::where('produk_id', $d->produk_id)
                            ->lockForUpdate()
                            ->first();

                        if (!$stok || $stok->jumlah < $d->qty) {
                            throw new \Exception('Stok tidak mencukupi');
                        }

                        $stok->decrement('jumlah', $d->qty);
                    }
                }

                $transaksi->update([
                    'status' => $request->status
                ]);
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Status transaksi diperbarui');

        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
