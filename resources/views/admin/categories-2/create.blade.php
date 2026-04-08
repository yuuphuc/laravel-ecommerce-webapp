@extends('layout.admin')

@section('title', 'Trang Add Category')

@section('content')
<h2 style="text-align: center;">Thêm Danh Mục Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.categories-2.cat-form')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#cat-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('cate2.store') }}"; // endpoint
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(res) {

                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                    if (res.errorflag === 'success') {
                        form[0].reset(); // xóa form nếu thành công
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = '<div class="alert alert-danger">';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                message += errors[key][0] + '<br>';
                            }
                        }
                        message += '</div>';
                        $('#message-area').html(message);
                    } else {
                        $('#message-area').html('<div class="alert alert-danger">Đã xảy ra lỗi không xác định!</div>');
                    }
                }

            });
        });
    });
</script>