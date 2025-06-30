<?php

namespace App\Models;
use App\Models\Harga;
use Illuminate\Database\Eloquent\Model;

class SetoranDetail extends Model
{
    protected $casts = [
        'tanggal_transaksi' => 'datetime', // Tambahkan casting ini
    ];
    
    protected $fillable = [
        'user_id',
        'nama',
        'daftar_id',
        'satuan',
        'harga',
        'subtotal',
        'total',
        'tanggal_transaksi',
    ];

    // App\Models\SetoranDetail.php
    public function daftar()
    {
        return $this->belongsTo(Daftar::class, 'daftar_id');
    }


    public function harga()
    {
        return $this->belongsTo(Harga::class, 'harga_id');
    }

    // Kas.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


