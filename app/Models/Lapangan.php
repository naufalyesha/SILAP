<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'map',
        'photo',
        'type',
        'description',
        'facilities',
        'vendor_id',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }
}
