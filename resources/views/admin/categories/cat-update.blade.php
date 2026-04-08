<form id="cat-update" method="POST" class="w-50 p-4 shadow mx-auto">
    @csrf
    <table class="table table-borderless">
        <tr>
            <td><label for="f-catname">Tên danh mục:</label></td>
            <td><input type="text" id="f-catname" name="catename" required class="form-control" value="{{ ($category->catename) }}"></td>
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
                    <a href="{{ route('cate.index') }}" class="btn btn-secondary">&lAarr; Quay về</a>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </td>
        </tr>
    </table>
</form>