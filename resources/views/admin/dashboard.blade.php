@extends('layout.admin')

@section('title', 'Trang Dashboard')

@section('content')
<h1>Chào mừng đến trang Dashboard!</h1>
<div class="container mt-4">
    <h1>Trang Quản Trị</h1>

    <div class="row mt-4">
        <!-- Tổng số -->
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center p-3">
                <h4>Sản phẩm</h4>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center p-3">
                <h4>Danh mục</h4>
                <h2>{{ $totalCategories }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white text-center p-3">
                <h4>Đơn hàng</h4>
                <h2>{{ $totalOrders }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white text-center p-3">
                <h4>Khách hàng</h4>
                <h2>{{ $totalCustomers }}</h2>
            </div>
        </div>
    </div>

    <!-- 5 sản phẩm mới nhất -->
    <div class="mt-5">
        <h3>5 Sản phẩm mới nhất</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Ngày thêm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latestProducts as $product)
                    <tr>
                        <td>{{ $product->proname }}</td>
                        <td>{{ number_format($product->price) }} VNĐ</td>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- 5 đơn hàng mới nhất -->
    <div class="mt-5">
        <h3>5 Đơn hàng mới nhất</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($latestOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->customer->fullname ?? 'Không xác định' }}</td>
                        <td>
                            {{ number_format($order->items->sum(function ($item) {
                                return $item->quantity * $item->price;
                            })) }} VNĐ
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection