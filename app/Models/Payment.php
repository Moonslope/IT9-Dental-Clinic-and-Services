<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'treatment_id',
        'total_amount',
        'payment_date',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }
}
