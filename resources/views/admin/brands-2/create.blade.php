@extends('layout.admin')

@section('title', 'Trang Add Brand')

@section('content')
<h2 style="text-align: center;">Thêm Thương Hiệu Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.brands-2.bra-form')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#bra-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('bra2.store') }}"; // endpoint
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
                        let messages = '';
                        for (let field in errors) {
                            messages += errors[field].join('<br>') + '<br>';
                        }
                        $('#message-area').html(`<div class="alert alert-danger">${messages}</div>`);
                    } else {
                        $('#message-area').html('<div class="alert alert-danger">Lỗi không xác định!</div>');
                    }
                }
            });
        });
    });
</script>