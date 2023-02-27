<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paymentInfo(){
        return $this->hasOne(PaymentSetting::class, 'payment_id', 'id')->where('seller_id', Auth::guard('vendor')->id());
    }
}
