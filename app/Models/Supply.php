<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'supply_name',
        'supply_price',
        'supply_description',
        'supply_quantity'
    ];

    public function treatmentSupplies()
    {
        return $this->hasMany(TreatmentSupply::class, 'supply_id', 'id');
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'supply_id', 'id');
    }
}
