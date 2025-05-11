<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'appointment_id',
        'status',
        'treatment_cost',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'treatment_id', 'id');
    }

    public function treatmentSupplies()
    {
        return $this->hasMany(TreatmentSupply::class, 'treatment_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
