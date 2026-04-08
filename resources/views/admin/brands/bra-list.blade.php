<div class="row">
    <div class="card-header">
        <i class="fas fa-list-alt me-1"></i>
        <td>
            <a href="{{route('bra.create')}}" class="btn btn-sm btn-success me-1" title="Thêm">Thêm thương hiệu <i class="fas fa-plus"></i></a>
        </td>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên Thương Hiệu</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item->brandname }}</td>
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
                            data-info="{{ $item->brandname }}" {{-- hoặc tên thương hiệu --}}
                            data-action="{{ route('bra.delete', ['id' => $item->id]) }}">
                            <i class="fas fa-trash" title="Xóa"></i>
                        </button>

                        <a href="{{ route('bra.edit', $item->id) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>
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
                    <option value="{{ route('bra.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="{{ route('bra.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ route('bra.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="{{ route('bra.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                {{ $list->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>