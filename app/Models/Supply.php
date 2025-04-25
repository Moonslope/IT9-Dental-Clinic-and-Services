<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = [
        'stock_in_id',
        'supply_name',
        'supply_description',
        'quantity',
    ];

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stock_in_id', 'id');
    }

    public function treatmentSupplies()
    {
        return $this->hasMany(TreatmentSupply::class, 'supply_id', 'id');
    }
}
