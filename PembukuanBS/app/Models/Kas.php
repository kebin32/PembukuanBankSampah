<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'tanggal',
        'aksi',
        'nominal',
        'saldo',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


