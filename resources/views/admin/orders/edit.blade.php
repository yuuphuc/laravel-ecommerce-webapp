@extends('layout.admin')

@section('title', 'Trang Edit Đơn Hàng')

@section('content')
<h2 style="text-align: center;">Cập Nhật Đơn Hàng</h2>

<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.orders.or-update')
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $('#or-update').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('or.update', $order->id) }}"; // endpoint
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                    if (res.errorflag === 'success') {
                        $('#f-description').val(res.updated.description);
                        $('#f-orderdate').val(res.updated.orderdate);
                        $('#f-customerid').val(res.updated.customerid);
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
