<script src="https://code.jquery.com/jquery-3.7.1.js"
     integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
</script>
<script>
    $(document).on('click', '.pagination a', function(e) {
        // prevent sự kiện click của thẻ a
        e.preventDefault();
        // lấy thuộc tính href của thẻ a
        var url = $(this).attr('href');
        // alert(url);
        // gửi yêu cầu ajax đến url (server )
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                //data là dữ liệu trả về từ server
                //cập nhật dữ liệu vào thẻ có id là #list
                $('#list').html(data);
                bindDeleteModal();
                if (typeof bindToggleRowEvent === 'function') {
                    bindToggleRowEvent();
                }

            }
        });
    });
    $(document).on('change', '#perpage', function(e) {
        // prevent sự kiện click của thẻ select
        e.preventDefault();
        // lấy thuộc tính href của thẻ select
        var url = $(this).val();
        // alert(url);
        // gửi yêu cầu ajax đến url (server )
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                //data là dữ liệu trả về từ server
                //cập nhật dữ liệu vào thẻ có id là #list
                $('#list').html(response);
                bindDeleteModal();
                if (typeof bindToggleRowEvent === 'function') {
                    bindToggleRowEvent();
                }
            }
        });
    });
</script>