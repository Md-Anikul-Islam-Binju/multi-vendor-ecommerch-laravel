<?php

namespace App\Models;

use App\User;
use App\Vendor;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $product_id)
 */
class Product extends Model
{
    protected $guarded = [];

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function get_subcategory(){
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function get_childcategory(){
        return $this->belongsTo(Category::class, 'childcategory_id');
    }

    public function get_brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function get_variations(){
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    public function get_features(){
        return $this->hasMany(ProductFeature::class, 'product_id');
    }

    public function get_galleryImages(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function offer_discount(){
        return $this->belongsTo(OfferProduct::class, 'id', 'product_id')->where('status', 'active');
    }

    public  function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public  function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function shipping_region(){
        return $this->belongsTo(State::class, 'ship_region_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class)->where('status', 1);
    }
    public function videos(){
        return $this->hasMany(ProductVideo::class);
    }

}
