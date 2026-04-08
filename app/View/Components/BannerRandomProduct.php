<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BannerRandomProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public $products;
    public function __construct()
    {
        // Lấy 5 sản phẩm ngẫu nhiên
        $this->products = Product::inRandomOrder(50)->take(20)->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Truyền vào view
        return view('components.banner-random-product', [
            'products' => $this->products
        ]);
    }
}
