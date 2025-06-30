<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $fillable = ['nasabah_id', 'tanggal', 'total'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function details()
    {
        return $this->hasMany(SetoranDetail::class);
    }
}
