<form id="or-form" method="POST" class="w-50 p-4 shadow mx-auto">
    @csrf

    <!-- Hiển thị tất cả lỗi sau khi validate -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $item)
                {{ $item }} <br>
            @endforeach
        </div>
    @endif

    <table class="table table-borderless">
        <tr>
            <td><label for="customerid">Khách hàng:</label></td>
            <td>
                <select name="customerid" id="customerid" class="form-select" required>
                    <option value="">-- Chọn khách hàng --</option>
                    @foreach($customers as $cus)
                        <option value="{{ $cus->id }}">{{ $cus->fullname }}</option>
                    @endforeach
                </select>
            </td>
        </tr>

        <tr>
            <td><label for="orderdate">Ngày đặt hàng:</label></td>
            <td>
                <input type="date" id="orderdate" name="orderdate"
                       class="form-control" value="{{ old('orderdate') }}" required>
            </td>
        </tr>

        <tr>
            <td><label for="description">Mô tả:</label></td>
            <td>
                <textarea id="description" name="description"
                          class="form-control" rows="3" required>{{ old('description') }}</textarea>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('or.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Thêm đơn hàng</button>
                </div>
            </td>
        </tr>
    </table>
</form>
