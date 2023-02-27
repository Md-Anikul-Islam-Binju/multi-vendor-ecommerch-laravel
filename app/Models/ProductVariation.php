<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function get_attribute(){
        return $this->belongsTo(ProductAttribute::class, 'attribute_id', 'id');
    }

    // get variation details by attribute_id in category filter page
    public function allVariationValues(){
        return $this->hasMany(ProductVariationDetails::class, 'attribute_id', 'attribute_id')->groupBy('attributeValue_name');
    }

    // get variation details by variation_id in product front details page
    public function get_variationDetails(){
        return $this->hasMany(ProductVariationDetails::class, 'variation_id');
    }
}
