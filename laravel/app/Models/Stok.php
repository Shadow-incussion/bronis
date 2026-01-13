<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';

    protected $fillable = [
        'produk_id',
        'jumlah',
        'tipe',
        'keterangan'
    ];

    // Relasi: stok milik satu produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
