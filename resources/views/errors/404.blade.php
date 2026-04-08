@extends('layout.admin')

@section('title', '404 - Not Found')

@section('content')
    <div style="text-align: center; margin-top: 50px;">
        <h1 style="font-size: 80px; color: orange;">404</h1>
        <h2>Trang bạn tìm kiếm không tồn tại.</h2>
        <a href="{{ route('dashboard') }}">Về trang chủ</a>
    </div>
@endsection
