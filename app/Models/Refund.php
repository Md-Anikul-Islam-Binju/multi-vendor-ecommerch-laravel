<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function refundConversations(){
        return $this->hasMany(RefundConversation::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
