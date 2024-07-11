<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // protected $dateFormat =  'd-m-Y H:i:s';

    protected $fillable = [
        'lapangan_id', 'vendor_id', 'date', 'start_time', 'end_time', 'price',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}

