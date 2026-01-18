<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'nama',
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
        return $this->hasOne(Stok::class, 'produk_id');
    }
    
    // Relasi ke detail transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
