@extends('layout.admin')

@section('title', 'Trang Cập Nhật Khách Hàng')

@section('content')
<h2 style="text-align: center;">Cập Nhật Khách Hàng</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.customers.cus-update')
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        $('#cus-update').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('cus.update', $customer->id) }}";
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                    if (res.errorflag === 'success') {
                        $('#f-fullname').val(res.updated.fullname);
                        $('#f-tel').val(res.updated.tel);
                        $('#f-address').val(res.updated.address);
                        $('#f-email').val(res.updated.email);
                    }
                },
                error: function (xhr) {
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
