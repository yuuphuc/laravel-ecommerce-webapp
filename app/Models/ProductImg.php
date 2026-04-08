<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'productimgs';

    protected $fillable = ['productid', 'fileName'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid');
    }
}
