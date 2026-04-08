<form id="pro-form" method="POST" action="{{ route('pro.store') }}" class="w-75 p-4 shadow mx-auto">
    @csrf
    <table class="table table-borderless">
        <tr>
            <td><label for="f-proname">Tên sản phẩm:</label></td>
            <td>
                <input type="text" id="f-proname" name="proname" required class="form-control" value="{{ old('proname') }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-price">Giá:</label></td>
            <td>
                <input type="number" id="f-price" name="price" required class="form-control" value="{{ old('price') }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-cateid">Danh mục:</label></td>
            <td>
                <select name="cateid" id="f-cateid" class="form-select" required>
                    @foreach ($listcate as $item)
                        <option value="{{ $item->cateid }}">{{ $item->catename }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="f-brandid">Thương hiệu:</label></td>
            <td>
                <select name="brandid" id="f-brandid" class="form-select" required>
                    @foreach ($listbrand as $item)
                        <option value="{{ $item->id }}">{{ $item->brandname }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td>
                <textarea name="description" id="f-description" rows="4" class="form-control">{{ old('description') }}</textarea>
            </td>
        </tr>
        <tr>
            <td><label for="status">Trạng thái:</label></td>
            <td>
                <input type="radio" id="active" name="status" value="1" required>
                <label for="active">Hoạt động</label>
                <input type="radio" id="inactive" name="status" value="0">
                <label for="inactive">Không hoạt động</label>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pro.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </td>
        </tr>
    </table>
</form>
