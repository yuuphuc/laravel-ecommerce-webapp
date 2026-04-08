<!-- Modal xác nhận -->
    <div class="modal fade" id="confirmdelete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="delete-form" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn xóa: <span class="info text-danger"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Xóa</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>