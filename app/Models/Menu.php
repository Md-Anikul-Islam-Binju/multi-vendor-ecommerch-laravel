<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function get_categories(){
        return $this->hasMany(Category::class, 'menu_id', 'id');
    }

    public function get_pages(){
        return $this->belongsTo(Page::class, 'source_id', 'id');
    }
}
