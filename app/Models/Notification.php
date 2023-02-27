<?php

namespace App\Models;

use App\Admin;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'fromUser');
    }

    public function staff(){
        return $this->belongsTo(Admin::class, 'fromUser');
    }
    public function product(){
        return $this->belongsTo(Product::class, 'item_id');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'item_id');
    }
    public function refund(){
        return $this->belongsTo(Refund::class, 'item_id');
    }
    public function review(){
        return $this->belongsTo(Review::class, 'item_id');
    }
}
