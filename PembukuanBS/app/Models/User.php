<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'saldo',
    ];

    // Optional helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isNasabah(): bool
    {
        return $this->role === 'nasabah';
    }
    
    public function nasabah()
    {
        return $this->hasOne(Nasabah::class, 'user_id');
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
