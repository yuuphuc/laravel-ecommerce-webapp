<div class="row">
    <div class="card-header">
        <i class="fas fa-clipboard-list me-1"></i>
        <a href="{{ route('orderit.create') }}" class="btn btn-sm btn-success me-1" title="Thêm">
            Thêm chi tiết đơn hàng <i class="fas fa-plus"></i>
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                <tr class="toggle-row" data-target="r{{ $loop->index }}" data-row-id="row{{ $loop->index }}">
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->orderid }}</td>
                    <td>{{ $item->product->proname ?? '[Không xác định]' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td>
                        <!-- Nút mở modal xác nhận xóa -->
                        <button
                            type="button"
                            class="btn btn-sm btn-danger btn-delete"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmdelete"
                            data-name="Chi tiết đơn hàng mã {{ $item->orderid }}"
                            data-action="{{ route('orderit.delete', ['id' => $item->id]) }}"
                            data-rowid="r{{ $loop->index }}">
                            <i class="fas fa-trash" title="Xóa"></i>
                        </button>




                        <a href="{{ route('orderit.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                <tr id="r{{ $loop->index }}" class="product-row d-none" data-product-id="row{{ $loop->index }}">
                    <td colspan="6">
                        <strong>Mô tả:</strong> {{ $item->description ?? 'Không có mô tả thêm.' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0">Số bản ghi/trang:</label>
                <select id="perpage" class="form-select form-select-sm" style="width: 80px;" pag-perpage>
                    <option value="{{ route('orderit.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="{{ route('orderit.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ route('orderit.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="{{ route('orderit.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                {{ $list->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>