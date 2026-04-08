<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class Category2Controller extends Controller
{
    public function index(Request $req, $perpage = 10)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10; // fallback an toàn
        }
        $list = Category::with(['products'])->orderBy('catename')->paginate((int)$perpage);
        if ($req->ajax()) {
            return view('admin.categories-2.cat-list', compact('list', 'perpage'));
        }
        return view('admin.categories-2.index', compact('list', 'perpage'));
    }
    public function create()
    {
        return view("admin.categories-2.create");
    }
    public function store(Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)
        $req->validate(
            [
                'catename' => 'required|min:10|max:100|unique:categories,catename',
                'status' => 'required|in:0,1'
            ],
            [
                'catename.required' => 'Tên loại sản phẩm không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
                'status.required' => 'Bạn phải chọn trạng thái',
                'status.in' => 'Trạng thái không hợp lệ'
            ],
            [
                'catename' => 'Tên loại sản phẩm',
                'status' => 'Trạng thái'
            ]
        );
        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            Category::create([
                'catename' => $req->catename,
                'description' => $req->description ?? null,
                'status' => $req->status
            ]);
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
        return redirect()->route('cate2.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function edit($id): View
    {
        $category  = Category::where('cateid', $id)
            ->first();
        return view("admin.categories-2.edit", compact('category'));
    }
    public function update($id, Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)
        //Lấy tham số id từ URL thông qua FromRequest
        $id = $req->route('id');
        // validate
        $req->validate(
            [
                'catename' => 'required|min:10|max:100|unique:categories,catename,' . $id. ',cateid',
                'status' => 'required|in:0,1'
            ],
            [
                'catename.required' => 'Tên loại sản phẩm không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
                'status.required' => 'Bạn phải chọn trạng thái',
                'status.in' => 'Trạng thái không hợp lệ'
            ],
            [
                'catename' => 'Tên loại sản phẩm',
                'status' => 'Trạng thái'
            ]
        );
        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            Category::where('cateid', $id)
                ->update(
                    [
                        'catename' => $req->catename,
                        'description' => $req->description ?? null,
                        'status' => $req->status
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
                    'catename' => $req->catename,
                    'description' => $req->description ?? null,
                    'status' => $req->status
                ]
            ]);
        }
        // Nếu không thì redirect như cũ
        // điều hướng ve route name cate.create (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        return redirect()->route('cate2.edit', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            Category::where('cateid', $id)->delete();
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
        return redirect()->route('cate2.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
