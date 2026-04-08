<div class="row">
    <div class="card-header">
        <i class="fas fa-list-alt me-1"></i>
        <td>
            <a href="{{route('pro2.create')}}" class="btn btn-sm btn-success me-1" title="Thêm">Thêm sản phẩm <i class="fas fa-plus"></i></a>
        </td>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Loại</th>
                    <th>Thương Hiệu</th>
                    <th class="text-end">Giá</th>
                    <th class="text-center">Ảnh</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item->productname }}</td>
                    <td>{{ optional($item->category)->catename ?? '[Không có]' }}</td>
                    <td>{{ optional($item->brand)->brandname ?? '[Không có]' }}</td>
                    <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} VND</td>

                    <td class="text-center">
                        @if ($item->fileName)
                        <img src="{{ asset('storage/products/' . $item->fileName) }}"
                            class="rounded border"
                            style="width: 80px; height: 60px; object-fit: cover;">
                        @else
                        <span class="text-muted fst-italic">[Không có ảnh]</span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if ($item->status == 1)
                        <i class="fas fa-eye text-success"></i> Hiển thị
                        @else
                        <i class="fas fa-eye-slash text-danger"></i> Ẩn
                        @endif
                    </td>

                    <td class="text-center">
                        <!-- Nút mở modal xác nhận xóa -->
                        <button type="button"
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmdelete"
                            data-info="{{ $item->productname }}"
                            data-action="{{ route('pro2.delete', ['id' => $item->id]) }}">
                            <i class="fas fa-trash" title="Xóa"></i>
                        </button>

                        <a href="{{ route('pro2.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-secondary" title="Khóa"><i class="fas fa-ban"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex align-items-center gap-2">
                <label for="" class="mb-0">Số bản ghi/trang:</label>
                <select name="" id="perpage" class="form-select form-select-sm" style="width: 80px;" pag-perpage>
                    <option value="{{ route('pro2.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="{{ route('pro2.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ route('pro2.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="{{ route('pro2.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                {{ $list->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>