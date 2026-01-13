<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'nama_customer',
        'no_wa',
        'total',
        'status',
        'user_id'
    ];

    // Relasi: transaksi diproses oleh admin/kasir
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: transaksi punya banyak detail
    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}
