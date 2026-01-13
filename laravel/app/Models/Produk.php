<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'harga',
        'stok',
        'foto',
        'status'
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relasi ke stok
    public function stok()
    {
        return $this->hasMany(Stok::class);
    }

    // Relasi ke detail transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
