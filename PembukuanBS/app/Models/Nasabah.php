<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $fillable = ["nama", "saldo", "user_id"]; // Pastikan 'user_id' bisa diisi

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the saldo attribute ensuring it is not negative.
     *
     * @param  float  $value
     * @return void
     * @throws \InvalidArgumentException
     */
    public function setSaldoAttribute($value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Saldo tidak boleh minus.');
        }
        $this->attributes['saldo'] = $value;
    }
}
