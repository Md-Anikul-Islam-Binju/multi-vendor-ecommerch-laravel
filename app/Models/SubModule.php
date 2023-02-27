<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function rolePermission(){
        return $this->hasOne(RolePermission::class, 'module_id');
    }
}
