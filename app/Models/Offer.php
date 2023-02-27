<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offer_products(){
        return $this->hasMany(OfferProduct::class, 'offer_id', 'id')->orderBy('position', 'asc');
    }
    public function offer_orders(){
        return $this->hasMany(Order::class, 'offer_id')->orderBy('id', 'asc');
    }

    public function shipping_region(){
        return $this->belongsTo(State::class, 'ship_region_id');
    }

}
