@extends('layout.admin')

@section('title', 'Trang Product')

@section('content')
<h1 class="mb-4">Danh sách sản phẩm</h1>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

<div id="list">
    @include('admin.products-2.pro-list')
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
    $(document).on('click', '.pagination a', function(e) {
        // prevent sự kiện click của thẻ a
        e.preventDefault();
        // lấy thuộc tính href của thẻ a
        var url = $(this).attr('href');
        // alert(url);
        // gửi yêu cầu ajax đến url (server )
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                //data là dữ liệu trả về từ server
                //cập nhật dữ liệu vào thẻ có id là #pro-list
                $('#pro-list').html(data);
                bindDeleteModal();
            }
        });
    });
    $(document).on('change', '#perpage', function(e) {
        // prevent sự kiện click của thẻ select
        e.preventDefault();
        // lấy thuộc tính href của thẻ select
        var url = $(this).val();
        // alert(url);
        // gửi yêu cầu ajax đến url (server )
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                //data là dữ liệu trả về từ server
                //cập nhật dữ liệu vào thẻ có id là #pro-list
                $('#pro-list').html(response);
                bindDeleteModal();
            }
        });
    });

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
                    // Gọi lại danh sách sản phẩm bằng AJAX
                    let currentPerPage = $('#perpage').val();
                    $.ajax({
                        url: currentPerPage,
                        method: 'GET',
                        success: function(listHtml) {
                            $('#pro-list').html(listHtml);
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