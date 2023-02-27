<?php

namespace App;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Review;
use App\Models\State;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class Vendor extends Authenticatable

{
	protected $guard = 'vendor';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function isOnline(){
        return Cache::has('UserOnline-'.$this->id);
    }

    public function get_country(){
        return $this->belongsTo(Country::class, 'id');
    }

    public function get_state(){
        return $this->belongsTo(State::class, 'id');
    }
    public function get_city(){
        return $this->belongsTo(City::class, 'id');
    }
    public function get_area(){
        return $this->belongsTo(Area::class, 'id');
    }
    public function allproducts(){
        return $this->hasMany(Product::class, 'vendor_id');
    }
    public function reviews(){
        return $this->hasMany(Review::class, 'vendor_id');
    }

    public function allorders(){
        return $this->hasMany(OrderDetail::class, 'vendor_id');
    }

}
