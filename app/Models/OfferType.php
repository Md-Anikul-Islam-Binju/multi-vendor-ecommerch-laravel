<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    use HasFactory;
    public function offers(){
        return $this->hasMany(Offer::class, 'offer_type', 'slug');
    }
}
