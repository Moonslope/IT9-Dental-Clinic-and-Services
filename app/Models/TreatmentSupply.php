<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentSupply extends Model
{
    protected $fillable = [
        'treatment_id',
        'supply_id',
        'quantity_used',
        'total_quantity'
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supply_id', 'id');
    }
}
