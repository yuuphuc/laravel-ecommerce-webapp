@extends('layout.admin')

@section('title', 'Chỉnh sửa Chi tiết đơn hàng')

@section('content')
<h2 style="text-align: center;">Chỉnh Sửa Chi Tiết Đơn Hàng</h2>

<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

<div id="list">
    @include('admin.orderitems.orderit-update')
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Lấy dữ liệu giá sản phẩm từ thẻ div ẩn
        let prices = $('#product-data').data('prices');

        function updatePrice() {
            let productId = $('#productid').val();
            let quantity = parseInt($('#quantity').val());
            let pricePerUnit = prices[productId] ?? 0;
            let total = pricePerUnit * (isNaN(quantity) ? 0 : quantity);
            $('#price').val(total.toFixed(2));
        }

        // Khi chọn sản phẩm hoặc nhập số lượng thì cập nhật đơn giá
        $('#productid, #quantity').on('change keyup input', function() {
            updatePrice();
        });

        updatePrice(); // Gọi 1 lần khi trang vừa load

        // Form submit bằng AJAX
        $('#orderit-update').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('orderit.update', $orderitem->id) }}";

            // Lấy dữ liệu và thêm thủ công _method=PUT
            let data = form.serialize() + '&_method=PUT';

            $.ajax({
                url: url,
                method: 'POST', // Laravel sẽ hiểu là PUT nhờ _method
                data: data,
                success: function(res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);
                    if (res.errorflag === 'success') {
                        $('#quantity').val(res.updated.quantity);
                        $('#price').val(res.updated.price);
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
                        $('#message-area').html('<div class="alert alert-danger">Xảy ra lỗi khi cập nhật!</div>');
                    }
                }
            });
        });
    });
</script>
@endsection