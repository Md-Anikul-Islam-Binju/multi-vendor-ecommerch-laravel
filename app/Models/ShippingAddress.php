<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function get_country(){
        return $this->belongsTo(Country::class, 'country');
    }

    public function get_state(){
        return $this->belongsTo(State::class, 'region');
    }
    public function get_city(){
        return $this->belongsTo(City::class, 'city');
    }
    public function get_area(){
        return $this->belongsTo(Area::class, 'area');
    }
}
