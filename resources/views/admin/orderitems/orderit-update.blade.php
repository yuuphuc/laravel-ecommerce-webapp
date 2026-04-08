<form id="orderit-update" method="POST" action="{{ route('orderit.update', $orderitem->id) }}" class="w-50 p-4 shadow mx-auto">
    @csrf


    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $item)
        {{ $item }} <br>
        @endforeach
    </div>
    @endif

    <table class="table table-borderless">
        <tr>
            <td><label for="orderid">Mã đơn hàng:</label></td>
            <td>
                <select id="orderid" name="orderid" class="form-select" required>
                    <option value="">-- Chọn đơn hàng --</option>
                    @foreach ($orders as $order)
                    <option value="{{ $order->id }}"
                        {{ (old('orderid', $orderitem->orderid) == $order->id) ? 'selected' : '' }}>
                        {{ $order->id }} - {{ $order->orderdate }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td><label for="productid">Sản phẩm:</label></td>
            <td>
                <select id="productid" name="productid" class="form-select" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        {{ (old('productid', $orderitem->productid) == $product->id) ? 'selected' : '' }}>
                        {{ $product->id }} - {{ $product->proname }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td><label for="quantity">Số lượng:</label></td>
            <td>
                <input type="number" id="quantity" name="quantity" class="form-control"
                    value="{{ old('quantity', $orderitem->quantity) }}" required>
            </td>
        </tr>

        <tr>
            <td><label for="price">Đơn giá:</label></td>
            <td>
                <input type="number" step="0.01" id="price" name="price" class="form-control"
                    value="{{ old('price', $orderitem->price) }}" required>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('orderit.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>

    <div id="product-data" data-prices='@json($products->pluck("price", "id"))'></div>
</form>