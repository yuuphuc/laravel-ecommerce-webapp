<?php

use App\Http\Controllers\Admin\Brand2Controller;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TestController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\Category2Controller;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\Product2Controller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\BrandClientController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryClientController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductClientController;

Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/category/{id}', [HomeController::class, 'index'])->name('category');

Route::get('/cartshow', function () {
    return view('client.cart.cartshow');
})->name('cartshow');
Route::get('/cartcheckout', function () {
    return view('client.cart.checkout');
})->name('checkout');
Route::post('/cartadd/{id}', [CartController::class, 'add'])->name('cartadd');
Route::get('/cartdel/{id}', [CartController::class, 'del'])->name('cartdel');
Route::post('/cartsave', [CartController::class, 'save'])->name('cartsave');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cartupdate');


Route::prefix('product')->group(function () {
    Route::get('/products', [ProductClientController::class, 'index'])->name('list');
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
    Route::get('/search', [ProductClientController::class, 'search'])->name('search');
});

Route::get('/category/{id}', [CategoryClientController::class, 'detail'])->name('cate.detail');
Route::get('/brand/{id}', [BrandClientController::class, 'detail'])->name('bra.detail');

// Hiển thị form đăng nhập
Route::get('/admin/login', [UserController::class, 'login'])->name('ad.login');
// Xử lý đăng nhập
Route::post('/admin/login', [UserController::class, 'loginpost'])->name('ad.loginpost');
// Hiển thị form quên mật khẩu
Route::get('/admin/forgotpass', [UserController::class, 'forgotpassform'])->name('ad.forgotpass');
// Xử lý gửi email mật khẩu mới
Route::post('/admin/forgotpass', [UserController::class, 'forgotpass'])->name('ad.forgotpasspost');
Route::prefix('admin')->middleware('auth')->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //User
    // những chuc nang chi đuoc su dung sau khi dang nhap thanh cong nen duoc khai bao trong nay
    Route::name('ad.')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        // Route GET: hiển thị form đổi mật khẩu
        Route::get('/changepass', [UserController::class, 'changepassform'])->name('changepass.form');
        // Route POST: xử lý cập nhật mật khẩu
        Route::post('/changepass', [UserController::class, 'changepass'])->name('changepass');
    });
    //User
    Route::name('us.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
    });

    //Category
    Route::name('cate.')->middleware('roles:1')->group(function () {
        Route::get('/categories/{perpage?}', [CategoryController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('store');
        //parrameter: tham số
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('/categories/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    });
    //Category2
    Route::name('cate2.')->middleware('roles:1')->group(function () {
        Route::get('/categories-2/{perpage?}', [Category2Controller::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/categories-2/create', [Category2Controller::class, 'create'])->name('create');
        Route::post('/categories-2/create', [Category2Controller::class, 'store'])->name('store');
        //parrameter: tham số
        Route::get('/categories-2/edit/{id}', [Category2Controller::class, 'edit'])->name('edit');
        Route::post('/categories-2/{id}', [Category2Controller::class, 'update'])->name('update');
        Route::post('/categories-2/delete/{id}', [Category2Controller::class, 'delete'])->name('delete');
    });
    //Product
    Route::name('pro.')->group(function () {
        Route::get('/products/{perpage?}', [ProductController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');

        Route::get('/products/create', [ProductController::class, 'create'])->name('create');
        Route::post('/products/create', [ProductController::class, 'store'])->name('store');
        Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/products/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('/products/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    });
    //Product2
    Route::name('pro2.')->group(function () {
        Route::get('/products-2/{perpage?}', [Product2Controller::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');

        Route::get('/products-2/create', [Product2Controller::class, 'create'])->name('create');
        Route::post('/products-2/create', [Product2Controller::class, 'store'])->name('store');
        Route::get('/products-2/edit/{id}', [Product2Controller::class, 'edit'])->name('edit');
        Route::post('/products-2/{id}', [Product2Controller::class, 'update'])->name('update');
        Route::delete('product-2/image/{id}', [Product2Controller::class, 'deleteImage'])->name('image.delete');
        Route::post('/products-2/delete/{id}', [Product2Controller::class, 'delete'])->name('delete');
    });
    //Brand
    Route::name('bra.')->middleware('roles:1')->group(function () {
        Route::get('/brands/{perpage?}', [BrandController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('create');
        Route::post('/brands/create', [BrandController::class, 'store'])->name('store');
        Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/brands/{id}', [BrandController::class, 'update'])->name('update');
        Route::post('/brands/delete/{id}', [BrandController::class, 'delete'])->name('delete');
    });
    //Brand2
    Route::name('bra2.')->middleware('roles:1')->group(function () {
        Route::get('/brands-2/{perpage?}', [Brand2Controller::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/brands-2/create', [Brand2Controller::class, 'create'])->name('create');
        Route::post('/brands-2/create', [Brand2Controller::class, 'store'])->name('store');
        Route::get('/brands-2/edit/{id}', [Brand2Controller::class, 'edit'])->name('edit');
        Route::post('/brands-2/{id}', [Brand2Controller::class, 'update'])->name('update');
        Route::post('/brands-2/delete/{id}', [Brand2Controller::class, 'delete'])->name('delete');
    });

    // Customer
    Route::name('cus.')->middleware('roles:1')->group(function () {
        Route::get('/customers/{perpage?}', [CustomerController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/customers/create', [CustomerController::class, 'store'])->name('store');
        Route::get('/customers/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
        Route::post('/customers/{id}', [CustomerController::class, 'update'])->name('update');
        Route::post('/customers/delete/{id}', [CustomerController::class, 'delete'])->name('delete');
    });

    // Order
    Route::name('or.')->middleware('roles:1')->group(function () {
        Route::get('/orders/{perpage?}', [OrderController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('create');
        Route::post('/orders/create', [OrderController::class, 'store'])->name('store');
        Route::get('/orders/edit/{id}', [OrderController::class, 'edit'])->name('edit');
        Route::post('/orders/{id}', [OrderController::class, 'update'])->name('update');
        Route::post('/orders/delete/{id}', [OrderController::class, 'delete'])->name('delete');
    });

    // OrderItem
    Route::name('orderit.')->middleware('roles:1')->group(function () {
        Route::get('/orderitems/{perpage?}', [OrderItemController::class, 'index'])
            ->where('perpage', '[0-9]+')  // Chỉ chấp nhận số
            ->name('index');
        Route::get('/orderitems/create', [OrderItemController::class, 'create'])->name('create');
        Route::post('/orderitems/create', [OrderItemController::class, 'store'])->name('store');
        Route::get('/orderitems/edit/{id}', [OrderItemController::class, 'edit'])->name('edit');
        Route::post('/orderitems/{id}', [OrderItemController::class, 'update'])->name('update');
        Route::post('/orderitems/delete/{id}', [OrderItemController::class, 'delete'])->name('delete');
    });
});
