<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // List of fields that can be filled when creating or updating an item
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

    // Define relationship: One item can have many sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
