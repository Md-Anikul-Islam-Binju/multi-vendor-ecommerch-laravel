<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSectionItem extends Model
{
     use HasFactory;
  
    protected $guarded = [];

    public function getCategories(){
        return $this->hasMany(SubCategory::class, 'category_id', 'item_id');
    } 

    public function category(){
        return $this->belongsTo(Category::class, 'item_id', 'id');
    }

    public function banner(){
        return $this->belongsTo(Banner::class, 'item_id', 'id');
    }
}
