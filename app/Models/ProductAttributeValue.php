<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValue extends Model
{
    //use SoftDeletes;
    protected $guarded = [];

    public function get_attribute(){
        return $this->belongsTo(ProductAttribute::class);
    }

}
