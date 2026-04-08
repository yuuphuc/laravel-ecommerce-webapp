@extends('layout.admin')

@section('title', 'Trang Edit Category')

@section('content')
<h2 style="text-align: center;">Cập Nhật Danh Mục Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.categories.cat-update')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#cat-update').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('cate.update', $category->cateid) }}"; // endpoint
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(res) {

                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                    if (res.errorflag === 'success') {
                        // Có thể hiển thị thông báo mà không cần reset
                        // Hoặc cập nhật lại input nếu server trả về dữ liệu
                        $('#f-catname').val(res.updated.catename); // nếu có trả về
                    }

                },
                error: function(xhr) {
                    $('#message-area').html('<div class="alert alert-danger">Đã xảy ra lỗi!</div>');
                }
            });
        });
    });
</script>