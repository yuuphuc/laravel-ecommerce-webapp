@extends('layout.admin')

@section('title', 'Trang Brand')

@section('content')
<h1 class="mb-4">Danh sách thương hiệu</h1>
<!-- nơi hiển thị message bằng cách gọi component -->
    <x-alert></x-alert>
    
<div id="list">
    @include('admin.brands.bra-list')
</div>
<!-- gọi component modal -->
<x-modal></x-modal>

<!-- gọi component ajax-pagination -->
<x-ajax-pagination></x-ajax-pagination>

@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
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
                    // Gọi lại danh sách danh mục bằng AJAX
                    let currentPerPage = $('#perpage').val();
                    $.ajax({
                        url: currentPerPage,
                        method: 'GET',
                        success: function(listHtml) {
                            $('#bra-list').html(listHtml);
                        }
                    });
                }
            },
            error: function() {
                $('#message-area').html('<div class="alert alert-danger">Xóa thất bại! Có thể danh mục đang được liên kết với sản phẩm.</div>');
            }
        });
    });
</script>