<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryClientController extends Controller
{
    public function detail($id)
    {
        // Lấy danh mục
        $category = Category::findOrFail($id);

        // Lấy danh sách sản phẩm theo danh mục
        $products = Product::where('cateid', $id)->orderBy('created_at', 'desc')->paginate(12);

        return view('client.category.detail', compact('category', 'products'));
    }
}
