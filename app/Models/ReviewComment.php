<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewComment extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
