<form id="cus-update" method="POST" class="w-50 p-4 shadow mx-auto">
    @csrf
    <!-- hiển thị tất cả lỗi sau khi validate -->
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $item)
        {{ $item }} <br>
        @endforeach
    </div>
    @endif
    <table class="table table-borderless">
        <tr>
            <td><label for="f-fullname">Họ tên:</label></td>
            <td>
                <input type="text" id="f-fullname" name="fullname" required class="form-control"
                    value="{{ $customer->fullname }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-tel">Số điện thoại:</label></td>
            <td>
                <input type="text" id="f-tel" name="tel" required class="form-control"
                    value="{{ $customer->tel }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-address">Địa chỉ:</label></td>
            <td>
                <textarea id="f-address" name="address" required class="form-control">{{ $customer->address }}</textarea>
            </td>
        </tr>
        
        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('cus.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>
</form>
