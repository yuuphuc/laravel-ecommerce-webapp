<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Danh sách người dùng</h2>
    @if(count($users) > 0)
        <table class="table table-bordered">
            <thead>
                <tr><th>Tên</th><th>Email</th></tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr><td>{{ $user['name'] }}</td><td>{{ $user['email'] }}</td></tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có dữ liệu cần hiển thị.</p>
    @endif
</div>
</body>
</html>
