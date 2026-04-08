<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class OrderController extends Controller
{
    public function index(Request $req, $perpage = 10): View|JsonResponse
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10;
        }

        $list = Order::with(['customer'])
            ->orderBy('orderdate', 'desc')
            ->paginate((int)$perpage);

        if ($req->ajax()) {
            return view('admin.orders.order-list', compact('list', 'perpage'));
        }

        return view('admin.orders.index', compact('list', 'perpage'));
    }

    public function create(): View
    {
        $customers = \App\Models\Customer::all(); // để chọn customer nếu cần
        return view('admin.orders.create', compact('customers'));
    }

    public function store(Request $req): JsonResponse|RedirectResponse
    {
        $req->validate(
            [
                'customerid' => 'required|exists:customers,id',
                'orderdate' => 'required|date',
                'description' => 'nullable|string|max:255',
            ],
            [
                'customerid.required' => 'Vui lòng chọn khách hàng',
                'customerid.exists' => 'Khách hàng không tồn tại',
                'orderdate.required' => 'Ngày đặt hàng không được để trống',
                'orderdate.date' => 'Ngày đặt hàng không hợp lệ',
                'description.max' => 'Mô tả không được quá 255 ký tự'
            ]
        );

        $message = null;
        $errorflag = 'danger';

        try {
            Order::create([
                'customerid' => $req->customerid,
                'orderdate' => $req->orderdate,
                'description' => $req->description ?? null
            ]);
            $message = 'Thêm đơn hàng thành công';
            $errorflag = 'success';
        } catch (Throwable $e) {
            $message = 'Lỗi thêm đơn hàng: ' . $e->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        return redirect()->route('or.create')
            ->with('mess', $message)
            ->with('errorflag', $errorflag)
            ->withInput();
    }

    public function edit($id): View
    {
        $order = Order::findOrFail($id);
        $customers = \App\Models\Customer::all();
        return view('admin.orders.edit', compact('order', 'customers'));
    }

    public function update(Request $req, $id): JsonResponse|RedirectResponse
    {
        $req->validate(
            [
                'customerid' => 'required|exists:customers,id',
                'orderdate' => 'required|date',
                'description' => 'nullable|string|max:255',
            ],
            [
                'customerid.required' => 'Vui lòng chọn khách hàng',
                'customerid.exists' => 'Khách hàng không tồn tại',
                'orderdate.required' => 'Ngày đặt hàng không được để trống',
                'orderdate.date' => 'Ngày đặt hàng không hợp lệ',
                'description.max' => 'Mô tả không được quá 255 ký tự'
            ]
        );

        $message = null;
        $errorflag = 'danger';

        try {
            Order::where('id', $id)->update([
                'customerid' => $req->customerid,
                'orderdate' => $req->orderdate,
                'description' => $req->description ?? null
            ]);
            $message = 'Cập nhật đơn hàng thành công';
            $errorflag = 'success';
        } catch (Throwable $e) {
            $message = 'Lỗi cập nhật đơn hàng: ' . $e->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        return redirect()->route('or.edit', $id)->with('message', $message)->with('errorflag', $errorflag)->withInput();
    }

    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            Order::where('id', $id)->delete();
            $message = 'Xóa thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        if ($req->ajax() || $req->wantsJson()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        return redirect()->route('or.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
