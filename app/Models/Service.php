<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'service_name',
        'service_description',
        'base_price',
        'estimated_max_price'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'service_id', 'id');
    }
}
