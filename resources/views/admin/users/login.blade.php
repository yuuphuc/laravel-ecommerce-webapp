@extends('layout.login')

@section('title', 'Đăng nhập hệ thống')

@section('content')
<form method="POST" action="{{ route('ad.loginpost') }}" class="login-box">
    @csrf
    {{-- Thông báo lỗi --}}
    @if (session('message'))
        <div style="color: yellow">{{ session('message') }}</div>
    @endif

    <h2>Đăng nhập</h2>

    <div class="input-group">
        <label>Email</label>
        <input type="text" name="email" value="{{ old('email') }}">
        @error('email')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div class="input-group">
        <label>Mật khẩu</label>
        <input type="password" name="password">
        @error('password')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-check">
        <label><input type="checkbox" name="remember"> Ghi nhớ đăng nhập</label>
    </div>

    <button type="submit">Đăng nhập</button>
    <a href="{{ route('ad.forgotpass') }}">Quên mật khẩu?</a>
</form>
@endsection
