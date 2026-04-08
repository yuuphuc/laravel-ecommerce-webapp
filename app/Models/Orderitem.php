<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Orderitem extends Model
{
    protected $fillable = ['orderid', 'productid', 'price', 'quantity'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}
