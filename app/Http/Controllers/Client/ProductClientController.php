<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::paginate(12);

        if ($request->ajax()) {
            return view('client.product.partials_list', compact('products'))->render(); // trả về partial nếu là AJAX
        }

        return view('client.product.index', compact('products'));
    }


    public function detail($id)
    {
        //chức năng xem chi tiết sản phẩm theo id hoặc slug
        $product = Product::with('category', 'brand')->findOrFail($id);
        return view('client.product.detail', compact('product'));
    }
    public function search(Request $req)
    {
        // chức năng để xử lý tìm kiếm sản phẩm
        $keyword = $req->input('keyword');

        $products = Product::where('proname', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('client.search', compact('products', 'keyword'));
    }
}
