@extends('layout.client')

@section('content')
@php
$cart = Session::get('cart', []);
$total = 0;
@endphp

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <h3 class="mb-4">📝 Vui lòng điền thông tin đặt hàng</h3>
        @csrf
        {{-- Alert --}}
        <x-alert></x-alert>

        {{-- Form Thông tin khách hàng --}}
        <form action="{{ route('cartsave') }}" method="POST" class="shadow-lg w-50 p-4 bg-light rounded mb-5">
            @csrf
            <h5 class="mb-3">Thông tin khách hàng</h5>
            <div class="mb-3">
                <label for="f-fullname" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="f-fullname" name="fullname" placeholder="Nhập họ tên" value="{{ old('fullname') }}">
                @error('fullname')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="f-tel" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="f-tel" name="tel" placeholder="Nhập số điện thoại" value="{{ old('tel') }}">
                @error('tel')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            <div class="mb-3">
                <label for="f-address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="f-address" name="address" placeholder="Nhập địa chỉ" value="{{ old('address') }}">
                @error('address')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            <div class="mb-3">
                <label for="f-description" class="form-label">Ghi chú</label>
                <textarea class="form-control" id="f-description" name="description" rows="3" placeholder="Ghi chú nếu có...">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-cash-coin me-2"></i> Xác nhận đặt hàng
            </button>
        </form>

        {{-- Bảng giỏ hàng --}}
        <h5 class="mb-3">🛒 Chi tiết giỏ hàng</h5>
        <table class="table table-bordered table-hover text-center align-middle">
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
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['proname'] }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-sm btn-outline-secondary btn-decrease" data-id="{{ $item['productid'] }}">−</button>
                            <span id="qty-{{ $item['productid'] }}" class="mx-2">{{ $item['quantity'] }}</span>
                            <button class="btn btn-sm btn-outline-secondary btn-increase" data-id="{{ $item['productid'] }}">+</button>
                        </div>
                    </td>
                    <td>{{ number_format($item['price']) }} VNĐ</td>
                    <td id="subtotal-{{ $item['productid'] }}">{{ number_format($subtotal) }} VNĐ</td>
                    <td>
                        <a href="{{ route('cartdel', ['id' => $item['productid']]) }}" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash3"></i> Xóa
                        </a>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-end fw-bold">Tổng tiền:</td>
                    <td colspan="2" class="text-center fw-bold text-danger" id="total-amount">
                        {{ number_format($total) }} đ
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end">
                        <a href="{{ route('homepage') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection