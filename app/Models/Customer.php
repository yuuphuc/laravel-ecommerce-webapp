<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = ['fullname', 'tel', 'address', 'password'];

    //Ẩn trường password khi trả về JSON
    protected $hidden = ['password', 'remember_token'];
    public function orders(): HasMany{
        return $this->hasMany(Order::class, 'customerid', 'id');
    }
}
