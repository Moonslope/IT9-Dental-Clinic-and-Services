<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'service_id',
        'patient_id',
        'dentist_id',
        'appointment_date',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class, 'dentist_id', 'id');
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'appointment_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'appointment_id', 'id');
    }
}
