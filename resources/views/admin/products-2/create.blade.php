@extends('layout.admin')

@section('title', 'Trang Add Product')

@section('content')
<h2 style="text-align: center;">Thêm Sản Phẩm Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.products-2.pro-form')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        // Xem trước ảnh khi chọn và kiểm tra kích thước <= 200KB
        const inputFile = document.getElementById('f-path');
        const previewImage = document.getElementById('preview-image');

        if (inputFile && previewImage) {
            inputFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 200 * 1024) {
                        alert("Ảnh vượt quá 200KB. Vui lòng chọn ảnh khác nhỏ hơn.");
                        inputFile.value = "";
                        previewImage.style.display = 'none';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Submit form bằng AJAX
        $('#pro-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = "{{ route('pro2.store') }}"; // endpoint
            let formElement = document.getElementById('pro-form');
            let formData = new FormData(formElement);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);
                    if (res.errorflag === 'success') {
                        formElement.reset();
                        $('#preview-image').hide();
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