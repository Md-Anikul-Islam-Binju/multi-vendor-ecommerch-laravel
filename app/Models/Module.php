<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sub_modules(){
        return $this->hasMany(Module::class, 'parent_id');
    }

    public function rolePermission(){
        return $this->hasOne(RolePermission::class, 'module_id');
    }
}
