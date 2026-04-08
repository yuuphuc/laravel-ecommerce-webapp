@extends('layout.admin')

@section('title', 'Trang Edit Product')

@section('content')
<h2 style="text-align: center;">Cập Nhật Sản Phẩm Mới</h2>
<!-- nơi hiển thị message bằng cách gọi component -->
<x-alert></x-alert>

@include('admin.products-2.pro-update')
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        const inputFile = document.getElementById('f-path');
        const previewImage = document.getElementById('preview-image');
        // Xem trước ảnh khi chọn
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


        if (inputFile && previewImage) {
            inputFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        $('#pro-update').on('submit', function(e) {
            e.preventDefault();

            let form = $(this)[0]; // Lấy form DOM thuần
            let url = "{{ route('pro2.update', $product->id) }}";
            let formData = new FormData(form); // FormData sẽ lấy cả file

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#message-area').html(`<div class="alert alert-${res.errorflag}">${res.message}</div>`);

                    if (res.errorflag === 'success') {
                        // Có thể cập nhật lại giá trị
                        $('#f-proname').val(res.updated.proname);
                        $('#f-price').val(res.updated.price);
                        $('#f-cateid').val(res.updated.cateid);
                        $('#f-brandid').val(res.updated.brandid);
                        $('#f-description').val(res.updated.description);
                        // làm cái này để cập nhật ảnh preview (nếu có trả về tên file mới)
                        if (res.updated.fileName) {
                            $('#preview-image').attr('src', '/storage/products/' + res.updated.fileName).show();
                        }
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
<script>
    $(document).on('click', '.btn-delete-image', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');
    const $box = $('#img-' + id);

    if (confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
        $.ajax({
            url: url,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                if (res.status === 'success') {
                    $box.remove();
                } else {
                    alert(res.message || 'Không thể xóa ảnh.');
                }
            },
            error: function () {
                alert('Lỗi trong quá trình xóa ảnh.');
            }
        });
    }
});

</script>

