<div class="row">
    <div class="card-header">
        <i class="fas fa-list-alt me-1"></i>
        <td>
            <a href="{{route('cate.create')}}" class="btn btn-sm btn-success me-1" title="Thêm">Thêm danh mục <i class="fas fa-plus"></i></a>
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
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item->catename }}</td>
                    <td><i class="fas fa-eye text-success"></i> Hiển thị</td>
                    <td>
                        <!-- Thêm class để bắt sự kiện -->
                        <form action="{{ route('cate.delete', $item->cateid) }}" method="POST" class="form-delete" style="display:inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <a href="{{ route('cate.edit', $item->cateid) }}" class="btn btn-sm btn-warning text-white me-1" title="Sửa"><i class="fas fa-edit"></i></a>

                        <!-- Xóa -> xac nhan thong qua modal -->
                        <button type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmdelete"
                            data-info="{{ $item->catename }}"
                            data-action="{{ route('cate.delete', ['id' => $item->cateid]) }}">
                            Xóa (modal)
                        </button>


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
                    <option value="{{ route('cate.index', 5) }}" {{ $perpage == 5 ? 'selected' : '' }}>5</option>
                    <option value="{{ route('cate.index', 10) }}" {{ $perpage == 10 ? 'selected' : '' }}>10</option>
                    <option value="{{ route('cate.index', 15) }}" {{ $perpage == 15 ? 'selected' : '' }}>15</option>
                    <option value="{{ route('cate.index', 100) }}" {{ $perpage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            <div>
                {{ $list->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
