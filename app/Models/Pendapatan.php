<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'finance_reports'; 

    protected $fillable = [
        'user_id', 'revenue', 'operational_cost', 'maintenance_cost', 'other_cost', 'report_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

