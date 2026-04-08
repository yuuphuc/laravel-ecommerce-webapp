@extends('layout.admin')

@section('title', '500 - Server Error')

@section('content')
    <div style="text-align: center; margin-top: 50px;">
        <h1 style="font-size: 80px; color: crimson;">500</h1>
        <h2>Đã xảy ra lỗi hệ thống.</h2>
        <a href="{{ route('dashboard') }}">Thử lại sau</a>
    </div>
@endsection
