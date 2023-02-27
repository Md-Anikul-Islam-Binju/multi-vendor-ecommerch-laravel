<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function products(){
        return $this->hasMany(Product::class, 'product_id', 'id');
    }

    public function sectionItems(){
        return $this->hasMany(HomepageSectionItem::class, 'section_id');
    }
}
