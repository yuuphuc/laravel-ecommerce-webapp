<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class BrandController extends Controller
{
    public function index(Request $req, $perpage = 5)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 5; // fallback an toàn
        }
        $list = Brand::orderBy('brandname')
            ->paginate((int)$perpage);
        if ($req->ajax()) {
            return view('admin.brands.bra-list', compact('list', 'perpage'));
        }
        return view('admin.brands.brands', compact('list', 'perpage'));;
    }
    public function create()
    {
        return view("admin.brands.create");
    }
    public function store(BrandRequest $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            Brand::create([
                'brandname' => $req->brandname,
                'description' => $req->description ?? null,
                'status' => $req->status,
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
        return redirect()->route('bra.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function edit($id): View
    {
        $brand  = Brand::where('id', $id)->first();
        return view("admin.brands.edit", compact('brand'));
    }
    public function update($id, BrandRequest $req): JsonResponse|RedirectResponse
    {
        // validate (bồ sung sau)

        // Sử dụng cơ chế bat lỗi try - catch khi insert DB
        // insert DB (query builder)
        $message = null;
        $errorflag = 'danger';
        try {
            Brand::where('id', $id)->update([
                'brandname' => $req->brandname,
                'description' => $req->description ?? null,
                'status' => $req->status,
            ]);
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
                    'brandname' => $req->brandname,
                    'description' => $req->description ?? null,
                    'updated_at' => now(),
                ]
            ]);
        }
        // Nếu không thì redirect như cũ
        // điều hướng ve route name bra.create (hoac co the sử dung back())
        // with('message', $message) : lưu giá trį message vào biến $message (flash session)
        // withInput(): lưu giá trị nhập vào ($req) vao flash session
        return redirect()->route('bra.edit', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            Brand::where('id', $id)->delete();
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
        return redirect()->route('bra.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
