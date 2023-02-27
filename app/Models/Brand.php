<?php

namespace App\Models;
use App\Vendor;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];

    public function get_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function seller(){
        return $this->hasOne(Vendor::class, 'id','vendor_id');
    }
}
