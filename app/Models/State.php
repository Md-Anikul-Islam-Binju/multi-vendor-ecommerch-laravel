<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed $config)
 */
class State extends Model
{
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public $timestamps = false;
}
