<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $fillable = ['nama', 'harga_kg'];

    public function details()
    {
        return $this->hasMany(SetoranDetail::class, 'harga_id');
    }
}