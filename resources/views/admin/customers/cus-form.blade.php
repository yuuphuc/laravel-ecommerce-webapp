<form id="cus-form" method="POST" class="w-50 p-4 shadow mx-auto">
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
            <td><label for="fullname">Họ tên:</label></td>
            <td>
                <input type="text" id="fullname" name="fullname"
                       class="form-control" value="{{ old('fullname') }}" required>
            </td>
        </tr>


        <tr>
            <td><label for="tel">Số điện thoại:</label></td>
            <td>
                <input type="text" id="tel" name="tel"
                       class="form-control" value="{{ old('tel') }}" required>
            </td>
        </tr>

        <tr>
            <td><label for="address">Địa chỉ:</label></td>
            <td>
                <textarea id="address" name="address"
                          class="form-control" required>{{ old('address') }}</textarea>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('cus.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Thêm khách hàng</button>
                </div>
            </td>
        </tr>
    </table>
</form>
