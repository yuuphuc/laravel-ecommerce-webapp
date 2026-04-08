<form id="or-update" method="POST" class="w-50 p-4 shadow mx-auto">
    @csrf

    <!-- Hiển thị tất cả lỗi sau khi validate -->
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $item)
        {{ $item }} <br>
        @endforeach
    </div>
    @endif

    <div id="message-area"></div>

    <table class="table table-borderless">
        <tr>
            <td><label for="f-orderdate">Ngày đặt hàng:</label></td>
            <td><input type="date" id="f-orderdate" name="orderdate" class="form-control" value="{{ $order->orderdate }}" required></td>
        </tr>

        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td><input type="text" id="f-description" name="description" class="form-control" value="{{ $order->description }}"></td>
        </tr>

        <tr>
            <td><label for="f-customerid">Khách hàng:</label></td>
            <td>
                <select name="customerid" id="f-customerid" class="form-select" required>
                    @foreach ($customers as $cus)
                    <option value="{{ $cus->id }}" {{ $order->customerid == $cus->id ? 'selected' : '' }}>
                        {{ $cus->fullname }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('or.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>
</form>
