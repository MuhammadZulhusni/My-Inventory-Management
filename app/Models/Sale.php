<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['item_id', 'quantity_sold', 'sold_at'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}