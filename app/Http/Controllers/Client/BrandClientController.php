<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;

class BrandClientController extends Controller
{
    public function detail($id)
    {
        $brand = Brand::findOrFail($id);
        $products = Product::where('brandid', $id)->orderBy('created_at', 'desc')->paginate(12);

        return view('client.brand.detail', compact('brand', 'products'));
    }
}

