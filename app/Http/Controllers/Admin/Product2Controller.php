<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImg;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class Product2Controller extends Controller
{
    public function index(Request $req, $perpage = 10)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10; // fallback an toàn
        }
        $list = Product::with(['category', 'brand'])
            ->select('id', 'proname as productname', 'price', 'description', 'cateid', 'brandid', 'fileName', 'status')
            ->paginate((int)$perpage);
        if ($req->ajax()) {
            return view('admin.products-2.pro-list', compact('list', 'perpage'));
        }
        return view('admin.products-2.index', compact('list', 'perpage'));
    }

    public function create(): View
    {
        // Lấy danh sách loại sản phẩm
        $listcate = Category::orderBy('catename')->get();
        // Lấy danh sách thương hiệu
        $listbrand = Brand::orderBy('brandname')->get();

        return view('admin.products-2.create', compact('listcate', 'listbrand'));
    }

    public function store(ProductRequest $req): JsonResponse|RedirectResponse
    {
        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $fileName = null;
        // kiểm tra file có được upload hay không
        // neu có thì luu vao thu muc storage/app/public/products
        if ($req->hasFile('fileName')) {
            // lay file từ request
            $file = $req->file('fileName');
            // Tạo tên ảnh = tên sản phẩm(dạng slug) + time()+ phần mở rộng
            // tên sản phẩm(slug): sử dung Str :: slug
            $fileName = Str::slug($req->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();
            // nếu có thì luu vao thu muc storage/app/public/products
            // 'public' : được cau hình trong config/filesystems.php
            $file->storeAs('products', $fileName, 'public');
        }
        $message = null;
        $errorflag = 'danger';
        try {
            $product = Product::create(
                [
                    'proname' => $req->proname,
                    'price' => $req->price,
                    'cateid' => $req->cateid,
                    'brandid' => $req->brandid,
                    'description' => $req->description,
                    //Lưu tên ảnh vào cột fileName
                    // 'fileName' => $fileName,
                    'fileName' => $fileName,
                    'status' => $req->status,
                ]
            );
            // Xử lý ảnh phụ (nhiều ảnh)
            if ($req->hasFile('images')) {
                foreach ($req->file('images') as $file) {
                    $fileName = Str::slug($req->proname) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('products', $fileName, 'public');

                    $product->images()->create([
                        'fileName' => $fileName
                    ]);
                }
            }
            $message = 'Thêm thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi : ' . $th->getMessage();
        }
        // điều hướng ve route name catecreate (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }
        // Nếu không thì redirect như cũ
        return redirect()->route('pro2.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function edit($id): View
    {
        $category  = Product::where('id', $id)->first();

        // Lấy sản phẩm cần chỉnh sửa
        $product = Product::where('id', $id)->first();
        // Lấy danh sách loại sản phẩm
        $listcate = Category::orderBy('catename')->get();
        // Lấy danh sách thương hiệu
        $listbrand = Brand::orderBy('brandname')->get();
        return view("admin.products-2.edit", compact('product', 'listcate', 'listbrand'));
    }
    public function update($id, ProductRequest $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $oldfileName = Product::where('id', $id)->value('fileName');
        if ($req->hasFile('fileName')) {
            //Lấy file ảnh từ request
            $file = $req->file('fileName');
            if ($oldfileName && file_exists(storage_path('app/public/products/' . $oldfileName))) {
                //Xóa ảnh cũ trong thư mục storage/app/public/products
                //unlink(): xóa file
                unlink(storage_path('app/public/products/' . $oldfileName));
            }
            $fileName = Str::slug($req->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $fileName, 'public');
        } else {
            $fileName = $oldfileName; // giữ ảnh cũ nếu không upload
        }
        $message = null;
        $errorflag = 'danger';
        try {
            Product::where('id', $id)
                ->update(
                    [
                        'proname' => $req->proname,
                        'price' => $req->price,
                        'cateid' => $req->cateid,
                        'brandid' => $req->brandid,
                        'description' => $req->description,
                        'fileName' => $fileName,
                        'status' => $req->status,
                    ]
                );

            // Xử lý ảnh phụ thêm mới
            if ($req->hasFile('images')) {
                foreach ($req->file('images') as $file) {
                    $fileNameSub = Str::slug($req->proname) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('products', $fileNameSub, 'public');

                    ProductImg::create([
                        'productid' => $id,
                        'fileName' => $fileNameSub,
                    ]);
                }
            }

            $message = 'Cập nhật thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi : ' . $th->getMessage();
        }
        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
                'updated' => [
                    'proname' => $req->proname,
                    'price' => $req->price,
                    'cateid' => $req->cateid,
                    'brandid' => $req->brandid,
                    'description' => $req->description,
                    'fileName' => $fileName,
                    'status' => $req->status,
                ]
            ]);
        }
        // Nếu không thì redirect như cũ
        // điều hướng ve route name cate.create (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        return redirect()->route('pro2.edit', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    
    public function deleteImage($id): JsonResponse
    {
        try {
            $img = ProductImg::findOrFail($id);
            $path = storage_path('app/public/products/' . $img->fileName);
            if (file_exists($path)) {
                unlink($path);
            }
            $img->delete();
            return response()->json(['status' => 'success', 'message' => 'Xóa ảnh phụ thành công']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Lỗi: ' . $th->getMessage()]);
        }
    }

    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            Product::where('id', $id)->delete();
            $message = 'Xóa thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        // Nếu là AJAX thì trả JSON
        if ($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        // Nếu là request thường thì redirect
        return redirect()->route('pro2.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
