<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_name',
        'address',
        'contact_number',
    ];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class, 'supplier_id', 'id');
    }
}
