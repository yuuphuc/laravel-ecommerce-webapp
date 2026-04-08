@extends('layout.admin')

@section('title', 'Trang Order Items')

@section('content')
<h1 class="mb-4">Danh sách chi tiết đơn hàng</h1>

<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>


<div id="list">
    @include('admin.orderitems.orderit-list')
</div>

<!-- gọi component modal -->
<x-modal></x-modal>

<!-- gọi component ajax-pagination -->
<x-ajax-pagination></x-ajax-pagination>
@endsection

@section('scripts')
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
        const deleteModal = document.getElementById('confirmdelete');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const name = button.getAttribute('data-name');
            const action = button.getAttribute('data-action');

            deleteModal.querySelector('.info').textContent = name;
            deleteModal.querySelector('#delete-form').setAttribute('action', action);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#confirmdelete').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const name = button.data('name');
            const action = button.data('action');
            const rowid = button.data('rowid');

            $(this).find('.info').text(name);
            $(this).find('form#delete-form').attr('action', action);
            $(this).find('form#delete-form').data('rowid', rowid);
        });

        $('#delete-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const rowid = form.data('rowid');
            const data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(res) {
                    if (res.errorflag === 'success') {
                        // Hiển thị thông báo thành công
                        $('#message-area').html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${res.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);

                        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmdelete'));
                        modal.hide();

                        $(`[data-target='${rowid}']`).closest('tr').remove();
                        $(`#${rowid}`).remove();
                    } else {
                        // Hiển thị thông báo lỗi
                        $('#message-area').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${res.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#message-area').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Xảy ra lỗi khi xóa! Có thể mục này đang được liên kết dữ liệu.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        });
    });
</script>
@endsection