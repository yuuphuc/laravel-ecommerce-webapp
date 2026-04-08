@extends('layout.login')

@section('title', 'Đổi mật khẩu')

@section('content')
<form method="POST" action="{{ route('ad.changepass') }}" class="login-box">
    @csrf

    <h2>Đổi mật khẩu</h2>

    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="input-group">
        <label for="old_password">Mật khẩu cũ</label>
        <input type="password" name="old_password">
        @error('old_password') <div style="color:red">{{ $message }}</div> @enderror
    </div>

    <div class="input-group">
        <label for="new_password">Mật khẩu mới</label>
        <input type="password" name="new_password">
        @error('new_password') <div style="color:red">{{ $message }}</div> @enderror
    </div>

    <div class="input-group">
        <label for="new_password_confirmation">Nhập lại mật khẩu mới</label>
        <input type="password" name="new_password_confirmation">
    </div>

    <button type="submit">Đổi mật khẩu</button>
</form>
@endsection
