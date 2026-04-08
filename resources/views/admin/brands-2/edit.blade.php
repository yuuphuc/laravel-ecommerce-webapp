@extends('layout.admin')

@section('title', 'Trang Edit Brand')

@section('content')
<h2 style="text-align: center;">Cập Nhật Thương Hiệu Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>
@include('admin.brands-2.bra-update')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('#bra-update').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('bra2.update', $brand->id) }}"; // endpoint
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
                        $('#f-brandname').val(res.updated.brandname); // nếu có trả về
                    }

                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '<div class="alert alert-danger">';
                        for (let field in errors) {
                            errorMsg += errors[field].join('<br>') + '<br>';
                        }
                        errorMsg += '</div>';
                        $('#message-area').html(errorMsg);
                    } else {
                        $('#message-area').html('<div class="alert alert-danger">Đã xảy ra lỗi!</div>');
                    }
                }
            });
        });
    });
</script>