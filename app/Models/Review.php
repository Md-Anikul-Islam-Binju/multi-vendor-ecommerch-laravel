<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function review_image_video(){
    	return $this->hasMany(ReviewImageVideo::class);
    }
    public function review_comments(){
    	return $this->hasMany(ReviewComment::class);
    }

}
