<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orderitem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class OrderItemController extends Controller
{
    public function index(Request $req, $perpage = 10): View|JsonResponse
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10;
        }

        $list = Orderitem::with(['order', 'product'])->orderByDesc('id')->paginate((int)$perpage);

        if ($req->ajax()) {
            return view('admin.orderitems.orderit-list', compact('list', 'perpage'));
        }

        return view('admin.orderitems.index', compact('list', 'perpage'));
    }

    public function create(): View
    {
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.create', compact('orders', 'products'));
    }

    public function store(Request $req): JsonResponse|RedirectResponse
    {
        $req->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ], [
            'required' => 'Trường :attribute là bắt buộc',
            'exists' => ':attribute không hợp lệ',
            'integer' => ':attribute phải là số nguyên',
            'numeric' => ':attribute phải là số',
            'min' => ':attribute phải lớn hơn :min'
        ], [
            'orderid' => 'Mã đơn hàng',
            'productid' => 'Mã sản phẩm',
            'quantity' => 'Số lượng',
            'price' => 'Giá'
        ]);

        $message = null;
        $errorflag = 'danger';

        try {
            Orderitem::create($req->only(['orderid', 'productid', 'quantity', 'price']));
            $message = 'Thêm chi tiết đơn hàng thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại: ' . $th->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag
            ]);
        }

        return redirect()->route('orderit.create')
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }

    public function edit($id): View
    {
        $orderitem = Orderitem::findOrFail($id);
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.edit', compact('orderitem', 'orders', 'products'));
    }

    public function update($id, Request $req): JsonResponse|RedirectResponse
    {
        $req->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ], [
            'required' => 'Trường :attribute là bắt buộc',
            'exists' => ':attribute không hợp lệ',
            'integer' => ':attribute phải là số nguyên',
            'numeric' => ':attribute phải là số',
            'min' => ':attribute phải lớn hơn :min'
        ], [
            'orderid' => 'Mã đơn hàng',
            'productid' => 'Mã sản phẩm',
            'quantity' => 'Số lượng',
            'price' => 'Giá'
        ]);

        $message = null;
        $errorflag = 'danger';

        try {
            Orderitem::where('id', $id)->update($req->only(['orderid', 'productid', 'quantity', 'price']));
            $message = 'Cập nhật thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại: ' . $th->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
                'updated' => Orderitem::find($id),
            ]);
        }

        return redirect()->route('orderit.edit', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }

    public function delete($id, Request $req): JsonResponse|RedirectResponse
    {
        $message = null;
        $errorflag = 'danger';

        try {
            Orderitem::where('id', $id)->delete();
            $message = 'Xóa thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        return redirect()->route('orderit.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }
}
