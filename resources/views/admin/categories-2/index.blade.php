@extends('layout.admin')

@section('title', 'Trang Category')

@section('content')
<h1 class="mb-4">Danh sách danh mục</h1>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

<div id="list">
    @include('admin.categories-2.cat-list')
</div>
<!-- gọi component modal -->
<x-modal></x-modal>

<!-- gọi component ajax-pagination -->
<x-ajax-pagination></x-ajax-pagination>
@endsection
<script>
    function bindToggleRowEvent() {
        document.querySelectorAll('.toggle-row').forEach(row => {
            row.addEventListener('click', function() {
                const targetId = row.getAttribute('data-target');
                const targetRow = document.getElementById(targetId);
                if (targetRow) {
                    targetRow.classList.toggle('d-none');
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        bindToggleRowEvent(); // chạy lần đầu
    });
</script>
<script>
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();

        if (!confirm('Bạn có chắc muốn xóa?')) return;

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(res) {
                $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                if (res.errorflag === 'success') {
                // Xóa dòng chính (gồm nút) và dòng phụ
                let modal = bootstrap.Modal.getInstance(document.getElementById('confirmdelete'));
                modal.hide(); // Đóng modal

                let mainRow = $(`[data-target='${targetRowId}']`).closest('tr');
                let productRow = $('#' + targetRowId);
                mainRow.remove();
                productRow.remove();
                }
            },
            error: function() {
                $('#message-area').html('<div class="alert alert-danger">Xóa thất bại! Có thể danh mục đang được liên kết với sản phẩm.</div>');
            }
        });
    });
</script>