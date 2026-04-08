<div class="row">
    <div class="card-header">
        <i class="fas fa-list-alt me-1"></i>
        <td>
            <a href="{{route('cate2.create')}}" class="btn btn-sm btn-success me-1" title="Thêm">Thêm danh mục <i class="fas fa-plus"></i></a>
        </td>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên Danh Mục</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                <tr class="toggle-row" data-target="r{{ $loop->index }}" data-row-id="row{{ $loop->index }}">
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item->catename }}</td>
                    <td>
                        @if ($item->status == 1)
                        <i class="fas fa-eye text-success"></i> Hiển thị
                        @else
                        <i class="fas fa-eye-slash text-danger"></i> Ẩn
                        @endif
                    </td>

                    <td>
                        <!-- Nút mở modal xác nhận xóa -->
                        <button type="button"
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmdelete"
                            data-info="{{ $item->catename }}"
                            data-action="{{ route('cate2.delete', ['id' => $item->cateid]) }}"
                            data-target-id="r{{ $loop->index }}">
                            <i class="fas fa-trash" title="Xóa"></i>
                        </button>
                        <a href="{{ route('cate2.edit', $item->cateid) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>

                        <a class="btn btn-sm btn-secondary" title="Khóa"><i class="fas fa-ban"></i></a>
                    </td>
                </tr>
                <!-- hiển thị danh sach sản phẩm theo loại sản phẩm -->
                <tr id="r{{ $loop->index }}" class="product-row d-none" data-product-id="row{{ $loop->index }}">

                    <td colspan="4">
                        <ul>
                            @forelse ($item->products as $pro)
                            <li>{{ $pro->proname }}</li>
                            @empty
                            <li><em>Không có sản phẩm nào</em></li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex align-items-center gap-2">
                <label for="" class="mb-0">Số bản ghi/trang:</label>
                <select name="" id="perpage" class="form-select form-select-sm" style="width: 80px;" pag-perpage>
                    <option value="{{ route('cate2.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="{{ route('cate2.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ route('cate2.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="{{ route('cate2.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                {{ $list->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>