@extends('layout.admin')

@section('title', 'Trang Add Category')

@section('content')
<h2 style="text-align: center;">Thêm Danh Mục Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.categories.cat-form')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#cat-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('cate.store') }}"; // endpoint
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
                    $('#message-area').html('<div class="alert alert-danger">Đã xảy ra lỗi!</div>');
                }
            });
        });
    });
</script>