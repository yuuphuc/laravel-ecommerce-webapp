<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê số lượng
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();

        // 5 sản phẩm mới nhất
        $latestProducts = Product::orderBy('created_at', 'desc')->take(5)->get();

        // 5 đơn hàng mới nhất (kèm customer + tính tổng tiền)
        $latestOrders = Order::with(['customer', 'items'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalCustomers',
            'latestProducts',
            'latestOrders'
        ));
    }
}
