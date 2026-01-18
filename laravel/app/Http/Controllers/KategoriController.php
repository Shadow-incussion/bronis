<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // ===============================
    // TAMPILKAN DATA KATEGORI
    // ===============================
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    // ===============================
    // SIMPAN KATEGORI BARU
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Kategori::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    // ===============================
    // FORM EDIT KATEGORI
    // ===============================
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    // ===============================
    // UPDATE KATEGORI
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    // ===============================
    // HAPUS KATEGORI
    // ===============================
    public function destroy($id)
    {
        Kategori::destroy($id);
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
