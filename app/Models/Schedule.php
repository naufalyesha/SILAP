<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // protected $dateFormat =  'd-m-Y H:i:s';

    protected $fillable = [
        'lapangan_id', 'vendor_id', 'date', 'start_time', 'end_time', 'price', 'status'
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function markAsPending()
    {
        $this->status= 2; // 2 for pending
        $this->save();
    }

    public function markAsAvailable()
    {
        $this->status= 0; // 0 for available
        $this->save();
    }
}
