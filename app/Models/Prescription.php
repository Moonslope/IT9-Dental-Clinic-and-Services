<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    // protected $fillable = [
    //     'treatment_id',
    //     'medication',
    //     'dosage',
    //     'date_issued',
    // ];

    protected $fillable = [
        'treatment_id',
        'patient_id',
        'medication',
        'instructions',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }
}
