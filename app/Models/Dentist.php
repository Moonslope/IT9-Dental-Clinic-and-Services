<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dentist extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'dentist_id', 'id');
    }
}
