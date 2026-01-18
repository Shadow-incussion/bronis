<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // tampilkan stok per produk
    public function index()
    {
        $produk = Produk::with('stok')->get();

        return view('admin.stok', compact('produk'));
    }

    // tambah stok
    public function tambah(Request $request, $produk_id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1'
        ]);

        Stok::create([
            'produk_id' => $produk_id,
            'jumlah' => $request->jumlah,
            'tipe' => 'masuk',
            'keterangan' => 'Tambah stok'
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    // kurangi stok
    public function kurang(Request $request, $produk_id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1'
        ]);

        Stok::create([
            'produk_id' => $produk_id,
            'jumlah' => $request->jumlah,
            'tipe' => 'keluar',
            'keterangan' => 'Kurangi stok'
        ]);

        return back()->with('success', 'Stok berhasil dikurangi');
    }
}
