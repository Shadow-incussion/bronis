<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.produk', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload foto
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/produk'), $namaFoto);
        }

        DB::transaction(function () use ($request, $namaFoto) {

            // SIMPAN PRODUK
            $produk = Produk::create([
                'nama' => $request->nama,
                'id_kategori' => $request->id_kategori,
                'harga' => $request->harga,
                'stok' => $request->stok, // optional / cadangan
                'status' => $request->status,
                'foto' => $namaFoto,
            ]);

            // SIMPAN STOK AWAL (INI KUNCI 🔥)
            Stok::create([
                'produk_id' => $produk->id,
                'jumlah' => $request->stok,
                'tipe' => 'masuk',
            ]);
        });

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'harga' => 'required|numeric',
            'status' => 'required|in:aktif,nonaktif',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk->nama = $request->nama;
        $produk->id_kategori = $request->id_kategori;
        $produk->harga = $request->harga;
        $produk->status = $request->status;

        if ($request->hasFile('foto')) {
            $namaFoto = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/produk'), $namaFoto);
            $produk->foto = $namaFoto;
        }

        $produk->save();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            Stok::where('produk_id', $id)->delete();
            Produk::destroy($id);
        });

        return back()->with('success', 'Produk berhasil dihapus');
    }
}
