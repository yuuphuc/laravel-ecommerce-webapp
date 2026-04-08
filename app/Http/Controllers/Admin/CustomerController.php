<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CustomerController extends Controller
{
    public function index(Request $req, $perpage = 10)
    {
        if (!is_numeric($perpage) || (int)$perpage <= 0) {
            $perpage = 10;
        }
        $list = Customer::orderBy('fullname')->paginate((int)$perpage);

        if ($req->ajax()) {
            return view('admin.customers.cus-list', compact('list', 'perpage'));
        }
        return view('admin.customers.index', compact('list', 'perpage'));
    }

    public function create()
    {
        return view("admin.customers.create");
    }

    public function store(Request $req): JsonResponse|RedirectResponse
    {
        $req->validate([
            'fullname' => 'required|min:5|max:100',
            'tel' => 'required|regex:/^09[0-9]{8}$/|unique:customers,tel',
            'address' => 'required|min:5|max:255'
        ], [
            'fullname.required' => 'Họ tên không được để trống',
            'tel.required' => 'Số điện thoại không được để trống',
            'tel.unique' => 'Số điện thoại đã tồn tại',
            'tel.regex' => 'Số điện thoại không hợp lệ',
            'address.required' => 'Địa chỉ không được để trống',
        ]);

        $message = null;
        $errorflag = 'danger';

        try {
            Customer::create([
                'fullname' => $req->fullname,
                'tel' => $req->tel,
                'address' => $req->address,
            ]);
            $message = 'Thêm thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ]);
        }

        return redirect()->route('cus.index')
            ->with('message', $message)
            ->with('errorflag', $errorflag)
            ->withInput();
    }

    public function edit($id): View
    {
        $customer = Customer::findOrFail($id);
        return view("admin.customers.edit", compact('customer'));
    }

    public function update($id, Request $req): JsonResponse|RedirectResponse
    {
        $req->validate([
            'fullname' => 'required|min:5|max:100',
            'tel' => 'required|regex:/^[0-9]{10,15}$/|unique:customers,tel,' . $id,
            'address' => 'required|min:5|max:255'
        ]);

        $message = null;
        $errorflag = 'danger';

        try {
            Customer::where('id', $id)->update([
                'fullname' => $req->fullname,
                'tel' => $req->tel,
                'address' => $req->address,
            ]);
            $message = 'Cập nhật thành công';
            $errorflag = 'success';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
        }

        if ($req->ajax()) {
            return response()->json([
                'message' => $message,
                'errorflag' => $errorflag,
            ], 200);
        }

        return redirect()->route('cus.edit', $id)
            ->withInput()
            ->with('message', $message)
            ->with('errorflag', $errorflag);
    }

    public function delete(Request $req, $id)
    {
        $message = 'Xảy ra lỗi khi xóa!';
        $errorflag = 'danger';

        try {
            $cus = Customer::findOrFail($id);
            $cus->delete();

            $message = 'Xóa khách hàng thành công!';
            $errorflag = 'success';
        } catch (\Exception $ex) {
            $message = 'Lỗi: ' . $ex->getMessage();
        }

        return response()->json([
            'message' => $message,
            'errorflag' => $errorflag,
        ]);
    }
}
