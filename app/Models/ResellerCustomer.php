<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResellerCustomer extends Model
{
    use HasFactory;

    public function get_state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'region');
    }

    public function get_city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function get_area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area');
    }


//    public function get_country(){
//        return $this->belongsTo(Country::class, 'country');
//    }
//
//    public function get_state(){
//        return $this->belongsTo(State::class, 'region');
//    }
//    public function get_city(){
//        return $this->belongsTo(City::class, 'city');
//    }
//    public function get_area(){
//        return $this->belongsTo(Area::class, 'area');
//    }


}
