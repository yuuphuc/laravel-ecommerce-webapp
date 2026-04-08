@extends('layout.client')

@section('content')
@php
//get giỏ hàng từ session
$cart = Session::get('cart', []);
$total = 0;
@endphp

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h3 class="mb-4">🛒 Thông tin giỏ hàng</h3>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                @php
                $total += $item['price'] * $item['quantity'];
                @endphp
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item['proname'] }}</td>

                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-sm btn-outline-secondary px-2 btn-decrease" data-id="{{ $item['productid'] }}">−</button>
                            <span id="qty-{{ $item['productid'] }}" class="mx-2">{{ $item['quantity'] }}</span>
                            <button class="btn btn-sm btn-outline-secondary px-2 btn-increase" data-id="{{ $item['productid'] }}">+</button>
                        </div>
                    </td>

                    <td>{{ number_format($item['price']) }} VNĐ</td>
                    <td id="subtotal-{{ $item['productid'] }}">
                        {{ number_format($item['price'] * $item['quantity']) }} VNĐ
                    </td>
                    <td>
                        <a href="{{ route('cartdel', ['id' => $item['productid']]) }}" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                    <td colspan="2" class="text-center fw-bold text-danger" id="total-amount">{{ number_format($total) }} đ</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start">
                        <a href="{{ route('homepage') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>
                    </td>
                    <td colspan="4" class="text-end">
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">Đặt hàng</a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</section>
@endsection