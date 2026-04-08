@extends('layout.admin')

@section('title', 'Trang Order')

@section('content')
<h1 class="mb-4">Danh sách Order</h1>

<x-alert></x-alert>

<div id="list">
    @include('admin.orders.or-list')
</div>

<x-modal></x-modal>

<x-ajax-pagination></x-ajax-pagination>
@endsection

@section('script')
<script>
     $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();

        if (!confirm('Bạn có chắc muốn xóa order này?')) return;

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(res) {
                console.log(res);
                $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                if (res.errorflag === 'success') {
                    let modal = bootstrap.Modal.getInstance(document.getElementById('confirmdelete'));
                    modal.hide();

                    let row = form.closest('tr');
                    row.remove();
                }
            },
            error: function() {
                $('#message-area').html('<div class="alert alert-danger">Xóa thất bại!</div>');
            }
        });
    });
</script>

@endsection