@extends('layout.login')

@section('title', 'Quên mật khẩu')

@section('content')
<form method="POST" action="{{ route('ad.forgotpasspost') }}" class="login-box">
    @csrf

    <h2>Quên mật khẩu</h2>

    @if (session('message'))
        <div style="color: green">{{ session('message') }}</div>
    @endif

    <div class="input-group">
        <label for="email">Email</label>
        <input type="text" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Gửi mật khẩu mới</button>

    {{-- Nút quay lại --}}
    <div style="margin-top: 15px;">
        <a href="{{ route('ad.login') }}" style="text-decoration: none; color: #007bff;">← Quay lại đăng nhập</a>
    </div>
</form>
@endsection
