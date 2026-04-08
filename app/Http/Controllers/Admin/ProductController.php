<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $req, $perpage = 10)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10; // fallback an toàn
        }
        $list = DB::table('products as p')
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename',
                'b.brandname'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->leftJoin('brands as b', 'p.brandid', 'b.id')
            ->paginate((int)$perpage);
        if ($req->ajax()) {
            return view('admin.products.pro-list', compact('list', 'perpage'));
        }
        return view('admin.products.products', compact('list', 'perpage'));
    }
   
    public function create(): View
    {
        // Lấy danh sách loại sản phẩm
        $listcate = DB::table('categories')->orderBy('catename')->get();
        // Lấy danh sách thương hiệu
        $listbrand = DB::table('brands')->orderBy('brandname')->get();

        return view('admin.products.create', compact('listcate', 'listbrand'));
    }

    public function store(Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            DB::table('products')->insert(
                [
                    'proname' => $req->proname,
                    'price' => $req->price,
                    'cateid' => $req->cateid,
                    'brandid' => $req->brandid,
                    'description' => $req->description
                ]
            );
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
        return redirect()->route('pro.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function edit($id): View
    {
        $category  = DB::table('products')
            ->where('id', $id)
            ->first();

        // Lấy sản phẩm cần chỉnh sửa
        $product = DB::table('products')->where('id', $id)->first();
        // Lấy danh sách loại sản phẩm
        $listcate = DB::table('categories')->orderBy('catename')->get();
        // Lấy danh sách thương hiệu
        $listbrand = DB::table('brands')->orderBy('brandname')->get();
        return view("admin.products.edit", compact('product', 'listcate', 'listbrand'));
    }
    public function update($id, Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            DB::table('products')
                ->where('id', $id)
                ->update(
                    [
                        'proname' => $req->proname,
                        'price' => $req->price,
                        'cateid' => $req->cateid,
                        'brandid' => $req->brandid,
                        'description' => $req->description
                    ]
                );
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
                    'description' => $req->description
                ]
            ]);
        }
        // Nếu không thì redirect như cũ
        // điều hướng ve route name cate.create (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        return redirect()->route('pro.create', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            DB::table('products')->where('id', $id)->delete();
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
        return redirect()->route('pro.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}