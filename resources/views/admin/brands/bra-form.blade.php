<form id="bra-form" method="POST" class="w-50 p-4 shadow mx-auto">
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
            <td><label for="f-brandname">Tên thương hiệu:</label></td>
            <td><input type="text" id="f-brandname" name="brandname" class="form-control" value="{{ old('brandname') }}" required></td>
        </tr>
        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td>
                <textarea id="f-description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </td>
        </tr>
        <tr>
            <td><label for="status">Trạng thái:</label></td>
            <td>
                <input type="radio" id="active" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }} required>
                <label for="active">Hoạt động</label>
                <input type="radio" id="inactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                <label for="inactive">Không hoạt động</label>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('bra.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Thêm thương hiệu</button>
                </div>
            </td>
        </tr>
    </table>
</form>