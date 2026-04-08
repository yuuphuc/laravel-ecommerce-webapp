<form id="pro-form" method="POST" action="{{ route('pro2.store') }}" enctype="multipart/form-data" class="w-75 p-4 shadow mx-auto">
    @csrf

    {{-- Hiển thị tất cả lỗi --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $item)
        {{ $item }} <br>
        @endforeach
    </div>
    @endif

    <table class="table table-borderless">
        <tr>
            <td><label for="f-proname">Tên sản phẩm:</label></td>
            <td>
                <input type="text" id="f-proname" name="proname" class="form-control" value="{{ old('proname') }}" required>
                @error('proname')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td><label for="f-price">Giá:</label></td>
            <td>
                <input type="number" id="f-price" name="price" class="form-control" value="{{ old('price') }}" required>
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td><label for="f-cateid">Danh mục:</label></td>
            <td>
                <select name="cateid" id="f-cateid" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($listcate as $item)
                    <option value="{{ $item->cateid }}" {{ old('cateid') == $item->cateid ? 'selected' : '' }}>
                        {{ $item->catename }}
                    </option>
                    @endforeach
                </select>
                @error('cateid')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td><label for="f-brandid">Thương hiệu:</label></td>
            <td>
                <select name="brandid" id="f-brandid" class="form-select">
                    <option value="">-- Không chọn --</option>
                    @foreach ($listbrand as $item)
                    <option value="{{ $item->id }}" {{ old('brandid') == $item->id ? 'selected' : '' }}>
                        {{ $item->brandname }}
                    </option>
                    @endforeach
                </select>
                @error('brandid')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td><label for="f-description">Mô tả:</label></td>
            <td>
                <textarea name="description" id="f-description" rows="4" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <td><label for="f-path">Hình ảnh</label></td>
            <td>
                <!-- Ảnh chính -->
                <input type="file" name="fileName" id="f-path" class="form-control m-2" accept="image/*">
                <img id="preview-image" src="#" alt="Ảnh xem trước" style="display: none; max-height: 150px;" class="mt-2 border rounded"> <!-- hiển thị lỗi cho element(fileName) với biến $message -->
                @error('fileName' )
                <p class="text-danger">{{ $message }}</p>
                @enderror

                <!-- Ảnh phụ -->
                <label for="f-images">Ảnh thêm (có thể chọn nhiều):</label>
                <input type="file" name="images[]" id="f-images" class="form-control m-2" accept="image/*" multiple>
                @error('images.*')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>
        <tr>
            <td><label for="status">Trạng thái:</label></td>
            <td>
                <input type="radio" id="active" name="status" value="1" {{ old('status') == '1' ? 'checked' : '' }} required>
                <label for="active">Hoạt động</label>
                <input type="radio" id="inactive" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }}>
                <label for="inactive">Không hoạt động</label>
                @error('status')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </td>
        </tr>

        <tr>
            <td colspan="2" class="pt-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pro2.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </td>
        </tr>
    </table>
</form>