<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    use HasFactory;
    public $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class, 'offer_id')->where('start_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now())->where('status', '=', 1)->where('offer_type', '!=', 'kanamachi');
    }

    public function offer_orders(){
        return $this->hasMany(OrderDetail::class, 'product_id', 'product_id');
    }


}
