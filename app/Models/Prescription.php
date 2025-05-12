<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{

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

    public function dentist()
    {
        return $this->belongsTo(Dentist::class, 'dentist_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
