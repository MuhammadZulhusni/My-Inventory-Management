<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'quantity',
        'price',
        'cost_price',
        'expiry_date',
        'category',
        'image'
    ];
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
