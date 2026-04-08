<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        //Lấy danh sách 20 sản phẩm mới nhất (created_at : ngày thêm sản phẩm)
        $listpro = Product::orderByDesc('created_at')->limit(20)->get();
         $categories = Category::all();
        return view('client.home', [
            "listpro"=>$listpro,
            "categories"=>$categories
        ]);
    }
}
