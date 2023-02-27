<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    //use SoftDeletes;
    protected $guarded = [];

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function variations(){
        return $this->hasMany(ProductVariation::class, 'attribute_id');
    }


    public function get_attrValues(){
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }
}
