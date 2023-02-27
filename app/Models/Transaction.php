<?php

namespace App\Models;

use App\Admin;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paymethod_name(){
        return $this->belongsTo(PaymentSetting::class, 'payment_method');
    }

    public function paymentGateway(){
        return $this->belongsTo(PaymentGateway::class, 'payment_method');
    }

    public function seller(){
        return $this->belongsTo(\App\Vendor::class, 'seller_id');
    }
    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function reseller(){
        return $this->belongsTo(Reseller::class, 'reseller_id');
    }
    public function addedBy(){
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
