<?php

namespace App\Models;

use App\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function staff(){
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
