@extends('layout.admin')

@section('title', 'Thêm Khách Hàng')

@section('content')
<h2 class="text-center">Thêm Khách Hàng Mới</h2>

<!-- Component hiển thị message -->
<x-alert></x-alert>


@include('admin.customers.cus-form')
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        if ($('#cus-form').length) {
            $('#cus-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let url = "{{ route('cus.store') }}";
                let data = form.serialize();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    success: function(res) {
                        if (res && res.message && res.errorflag) {
                            $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);
                            if (res.errorflag === 'success') {
                                form[0].reset();
                            }
                        } else {
                            $('#message-area').html('<div class="alert alert-warning">Server không trả về dữ liệu hợp lệ.</div>');
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
        }
    });
</script>
@endsection