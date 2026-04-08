@extends('layout.admin')

@section('title', 'Thêm Chi Tiết Đơn Hàng')

@section('content')
<h2 style="text-align: center;">Thêm Chi Tiết Đơn Hàng Mới</h2>
<x-alert></x-alert>
@include('admin.orderitems.orderit-form')
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        const pricesElement = document.getElementById('product-data');
        const productPrices = JSON.parse(pricesElement.dataset.prices);
        const productSelect = document.getElementById('productid');
        const quantityInput = document.getElementById('quantity');
        const priceInput = document.getElementById('price');

        function updatePrice() {
            const selectedProductId = productSelect.value;
            const unitPrice = parseFloat(productPrices[selectedProductId]) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const totalPrice = unitPrice * quantity;
            priceInput.value = totalPrice.toFixed(2);
        }

        productSelect.addEventListener('change', updatePrice);
        quantityInput.addEventListener('input', updatePrice);

        $('#orderit-form').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let url = "{{ route('orderit.store') }}";
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);
                    if (res.errorflag === 'success') {
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = '<div class="alert alert-danger">';
                        for (let key in errors) {
                            message += errors[key][0] + '<br>';
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
@endsection