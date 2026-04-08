<div class="card-body">
    <div class="card-header">
        <i class="fas fa-list-alt me-1"></i>
        <a href="{{ route('cus.create') }}" class="btn btn-sm btn-success me-1" title="Thêm">Thêm khách hàng <i class="fas fa-plus"></i></a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->fullname }}</td>
                <td>{{ $item->tel }}</td>
                <td>{{ $item->address }}</td>
                <td class="text-center">
                    <!-- Nút sửa -->
                    <a href="{{ route('cus.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa">
                        <i class="fas fa-edit"></i>
                    </a>

                    <!-- Nút xóa với modal xác nhận -->
                    <button type="button"
                        class="btn btn-sm btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmdelete"
                        data-info="{{ $item->fullname }}"
                        data-action="{{ route('cus.delete', $item->id) }}">
                        <i class="fas fa-trash" title="Xóa"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex align-items-center gap-2">
            <label class="mb-0">Số bản ghi/trang:</label>
            <select id="perpage" class="form-select form-select-sm" style="width: 80px;" pag-perpage>
                <option value="{{ route('cus.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                <option value="{{ route('cus.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                <option value="{{ route('cus.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                <option value="{{ route('cus.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>

        <div>
            {{ $list->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
