<?php

namespace App;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Order;
use App\Models\Package;
use App\Models\ShippingAddress;
use App\Models\State;
use App\Models\Zone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

/**
 * @method static find(int|string|null $id)
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isOnline(){
        return Cache::has('UserOnline-'.$this->id);
    }

    public function get_shipping_address(){
        return $this->hasMany(ShippingAddress::class);
    }

    public function get_country(){
        return $this->hasOne(Country::class, 'id','country');
    }

    public function get_state(){
        return $this->hasOne(State::class, 'id', 'region');
    }
    public function get_city(){
        return $this->hasOne(City::class, 'id', 'city');
    }
    public function get_area(){
        return $this->hasOne(Area::class, 'id','area');
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }


}
