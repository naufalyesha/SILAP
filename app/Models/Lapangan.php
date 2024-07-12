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

    protected $casts = [
        'photo' => 'array', // Mengubah kolom 'photo' menjadi array secara otomatis
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'lapangan_id');
    }

    // Accessor untuk mengakses daftar foto sebagai array
    public function getPhotoAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator untuk menyimpan daftar foto sebagai JSON
    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = json_encode($value);
    }

    // Accessor untuk mendapatkan foto pertama
    public function getFirstPhotoAttribute()
    {
        return $this->photo[0] ?? 'default.jpg';
    }
}
