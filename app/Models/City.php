<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $region)
 */
class City extends Model
{
    protected $guarded = [];

    public function state(){
        return $this->belongsTo(State::class);
    }

    public $timestamps = false;
}
