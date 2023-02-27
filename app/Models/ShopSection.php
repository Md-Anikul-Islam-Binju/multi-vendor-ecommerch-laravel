<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopSection extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function products(){
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
}
