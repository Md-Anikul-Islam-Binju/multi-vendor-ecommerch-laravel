<?php

namespace App\Models;

use App\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherTimeline extends Model
{
    use HasFactory;
    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
    public function voucherNotify(){
        return $this->hasMany(Notification::class, 'item_id', 'invoice_id');
    }
}
