<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'supply_name',
        'quantity_received',
        'date_received',
        'user_id',
        'supplier_id',
    ];

    public function supplies()
    {
        return $this->hasMany(Supply::class, 'stock_in_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
