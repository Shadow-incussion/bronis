<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        $produk = Produk::all();      // ambil semua produk
        $kategori = Kategori::all();  // ambil semua kategori

        return view('home', compact('produk', 'kategori'));
    }
}
