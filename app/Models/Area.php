<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $city)
 */
class Area extends Model
{
    protected $guarded = [];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public $timestamps = false;
}
