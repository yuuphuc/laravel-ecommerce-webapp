<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $req)
    {
        //chức năng này thực hiện thêm giỏ hàng (session)
        // lấy id từ URL (Xem đường dẫn -> devtool)
        $id = $req->route('id');
        // Lấy product trong db
        $product = Product::where("id", $id)->first();
        // lấy giỏ hàng từ session, nếu chưa tồn tại trả về mảng rỗng
        $cart = Session::get('cart', []);
        // kiểm tra xem giỏ hàng có id sản phẩm chưa
        if (isset($cart[$id])) {
            // nếu tồn tại rồi - tăng số lượng
            $cart[$id]['quantity'] += 1;
        } else {
            // nếu chưa tồn tại - tạo thêm sản phẩm
            $cart[$id] = [
                'productid' => $product->id,
                'proname' => $product->proname,
                'quantity' => 1,
                'price' => $product->price,
            ];
        }
        // lưu lại vào session
        Session::put('cart', $cart);
        // điều hướng về trang trước
        return redirect()->back();
    }

    public function del($id)
    {
        //chức năng này thực hiện xóa giỏ hàng (session)
        // lấy giỏ hàng từ session, nếu chưa tồn tại trả về mảng rỗng
        $cart = Session::get('cart', []);
        // kiểm tra xem giỏ hàng có id sản phẩm chưa
        if (isset($cart[$id])) {
            // nếu tồn tại rồi - tăng số lượng
            unset($cart[$id]);
        }
        // lưu lại vào session
        Session::put('cart', $cart);
        // điều hướng về trang trước
        return redirect()->back();
    }

    public function updateQuantity(Request $request)
    {
        $id = $request->productid;
        $action = $request->action;
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            if ($action === 'increase') {
                $cart[$id]['quantity'] += 1;
            } elseif ($action === 'decrease') {
                $cart[$id]['quantity'] -= 1;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }
        }

        Session::put('cart', $cart);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'quantity' => $cart[$id]['quantity'] ?? 0,
            'subtotal' => number_format(($cart[$id]['price'] ?? 0) * ($cart[$id]['quantity'] ?? 0)),
            'total' => number_format($total),
            'removed' => !isset($cart[$id]),
        ]);
    }


    public function save(Request $req)
    {
        // 1. Validate dữ liệu người dùng nhập
        $req->validate([
            'fullname' => 'required|string|min:5|max:100',
            'tel' => 'required|regex:/^[0-9]{10,11}$/',
            'address' => 'required|string|min:5|max:200',
            'description' => 'nullable|string|max:255',
        ], [
            'fullname.required' => 'Họ tên không được bỏ trống',
            'fullname.min' => 'Họ tên phải ít nhất 5 ký tự',
            'tel.required' => 'Số điện thoại không được bỏ trống',
            'tel.regex' => 'Số điện thoại không hợp lệ',
            'address.required' => 'Địa chỉ không được bỏ trống',
        ]);

        // 2. Lấy giỏ hàng từ session
        $cart = Session::get('cart');

        if (empty($cart)) {
            return redirect()->back()->with('mess', 'Không tồn tại giỏ hàng');
        }

        // 3. Kiểm tra và thêm customer nếu chưa có
        $customer = Customer::where('tel', $req->tel)->first();
        $customerid = $customer?->id ?? Customer::create([
            'fullname' => $req->fullname,
            'tel' => $req->tel,
            'address' => $req->address
        ])->id;

        // 4. Tạo đơn hàng
        $order = Order::create([
            'customerid' => $customerid,
            'description' => $req->description,
        ]);

        // 5. Tạo chi tiết đơn hàng
        foreach ($cart as $item) {
            Orderitem::create([
                'orderid' => $order->id,
                'productid' => $item['productid'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        // 6. Xóa giỏ hàng khỏi session
        Session::forget('cart');

        // 7. Quay lại với thông báo
        return redirect()->back()
            ->withInput()
            ->with('mess', 'Đặt hàng thành công. Anh/chị vui lòng đợi nhân viên liên hệ để xác nhận.');
    }
}
