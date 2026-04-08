<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'cateid';
    protected $attributes = [ 
        'description' => 'Chưa có mô tả' 
    ];
    protected $fillable = ['catename', 'description', 'status'];


    //1 Category có nhiều Product
    public function products(){
        return $this->hasMany(Product::class, 'cateid', 'cateid');
    }
}
