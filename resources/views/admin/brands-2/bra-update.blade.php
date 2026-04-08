<form id="bra-update" method="POST" class="w-50 p-4 shadow mx-auto">
    @csrf
    <!-- Hiển thị tất cả lỗi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $err)
                {{ $err }} <br>
            @endforeach
        </div>
    @endif
    <table class="table table-borderless">
        <tr>
            <td><label for="f-brandname">Tên danh mục:</label></td>
            <td>
                <input type="text" id="f-brandname" name="brandname" required class="form-control" value="{{ ($brand->brandname) }}">
                @error('brandname')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td>
                <textarea id="f-description" name="description" class="form-control" rows="3">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <td><label for="status">Trạng thái:</label></td>
            <td>
                <input type="radio" id="active" name="status" value="1" {{ $brand->status == 1 ? 'checked' : '' }} required>
                <label for="active">Hoạt động</label>
                <input type="radio" id="inactive" name="status" value="0" {{ $brand->status == 0 ? 'checked' : '' }}>
                <label for="inactive">Không hoạt động</label>
                @error('status')
                    <br><small class="text-danger">{{ $message }}</small>
                @enderror
            </td>
        </tr>
        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('bra2.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>
</form>