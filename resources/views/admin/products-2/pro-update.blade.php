<form id="pro-update" method="POST" action="{{ route('pro2.update', $product->id) }}" enctype="multipart/form-data" class="w-75 p-4 shadow mx-auto">
    @csrf
    {{-- Hiển thị tất cả lỗi --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $err)
        {{ $err }}<br>
        @endforeach
    </div>
    @endif

    <table class="table table-borderless">
        <tr>
            <td><label for="f-proname">Tên sản phẩm:</label></td>
            <td>
                <input type="text" id="f-proname" name="proname" required class="form-control"
                    value="{{ old('proname', $product->proname) }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-price">Giá:</label></td>
            <td>
                <input type="number" id="f-price" name="price" required class="form-control"
                    value="{{ old('price', $product->price) }}">
            </td>
        </tr>
        <tr>
            <td><label for="f-cateid">Danh mục:</label></td>
            <td>
                <select name="cateid" id="f-cateid" class="form-select" required>
                    @foreach ($listcate as $item)
                    <option value="{{ $item->cateid }}"
                        {{ old('cateid', $product->cateid) == $item->cateid ? 'selected' : '' }}>
                        {{ $item->catename }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="f-brandid">Thương hiệu:</label></td>
            <td>
                <select name="brandid" id="f-brandid" class="form-select">
                    <option value="">-- Không chọn --</option>
                    @foreach ($listbrand as $item)
                    <option value="{{ $item->id }}"
                        {{ old('brandid', $product->brandid) == $item->id ? 'selected' : '' }}>
                        {{ $item->brandname }}
                    </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td>
                <textarea name="description" id="f-description" rows="4"
                    class="form-control">{{ old('description', $product->description) }}</textarea>
            </td>
        </tr>
        <tr>
            <td><label for="f-path">Hình ảnh:</label></td>
            <td>
                <input type="file" name="fileName" id="f-path" class="form-control mb-2" accept="image/*">
                <!-- Ảnh hiện tại -->
                @if ($product->fileName)
                <p class="text-muted mb-1">Ảnh hiện tại:</p>
                <img src="{{ asset('storage/products/' . $product->fileName) }}"
                    alt="Ảnh hiện tại" class="img-thumbnail mb-2" style="max-height: 120px;">
                @endif
                <!-- Ảnh xem trước -->
                <p class="text-muted mb-1">Xem trước ảnh mới:</p>
                <img id="preview-image" src="#" alt="Ảnh xem trước" style="display: none; max-height: 120px;" class="border rounded">
                @error('fileName')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        @if ($product->images && $product->images->count())
        <tr>
            <td><label>Ảnh phụ:</label></td>
            <td>
                <div class="row">
                    @foreach ($product->images as $img)
                    <div class="col-md-3 text-center mb-3" id="img-{{ $img->id }}">
                        <img src="{{ asset('storage/products/' . $img->fileName) }}"
                            class="img-thumbnail" style="height: 100px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger mt-1 btn-delete-image"
                            data-id="{{ $img->id }}"
                            data-url="{{ route('pro2.image.delete', $img->id) }}                            Xóa
                        </button>

                    </div>
                    @endforeach
                </div>
            </td>
        </tr>
        @endif

        <tr>
            <td><label for=" images">Thêm ảnh phụ mới:</label>
            </td>
            <td>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                @error('images.*')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td><label for="status">Trạng thái:</label></td>
            <td>
                <input type="radio" id="active" name="status" value="1"
                    {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                <label for="active">Hoạt động</label>
                <input type="radio" id="inactive" name="status" value="0"
                    {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                <label for="inactive">Không hoạt động</label>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pro2.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>
</form>