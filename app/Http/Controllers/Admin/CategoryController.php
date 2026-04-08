<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;


class CategoryController extends Controller
{
    public function index(Request $req, $perpage = 10)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10; // fallback an toàn
        }
        $list = DB::table("categories")
            ->orderBy('catename')
            ->paginate((int)$perpage);
        if ($req->ajax()) {
            return view('admin.categories.cat-list', compact('list', 'perpage'));
        }
        return view('admin.categories.categories', compact('list', 'perpage'));
    }
    public function create()
    {
        return view("admin.categories.create");
    }
    public function store(Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            DB::table('categories')->insert(
                ['catename' => $req->catename]
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
        return redirect()->route('cate.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function edit($id): View
    {
        $category  = DB::table('categories')
            ->where('cateid', $id)
            ->first();
        return view("admin.categories.edit", compact('category'));
    }
    public function update($id, Request $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            DB::table('categories')
                ->where('cateid', $id)
                ->update(
                    ['catename' => $req->catename]
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
                    'catename' => $req->catename
                ]
            ]);
        }
        // Nếu không thì redirect như cũ
        // điều hướng ve route name cate.create (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        return redirect()->route('cate.create', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            DB::table('categories')->where('cateid', $id)->delete();
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
        return redirect()->route('cate.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
