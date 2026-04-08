<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable =
    [
        'proname',
        'price',
        'brandid',
        'cateid',
        'description',
        'fileName',
        'status',
    ];

    // 1 Product thuộc về 1 Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid')
            ->select(['cateid', 'catename']);
    }

    // 1 Product thuộc về 1 Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id')
            ->select(['id', 'brandname']);
    }

    // 1 Product có thể cs nhiều ProductImage
    public function images()
    {
        return $this->hasMany(ProductImg::class, 'productid');
    }
}
