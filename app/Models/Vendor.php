<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Vendor extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'email',
        'nama',
        'alamat',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function lapangans()
    {
        return $this->hasMany(Lapangan::class);
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
