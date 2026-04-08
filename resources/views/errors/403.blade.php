@extends('layout.admin')

@section('title', '403 - Cấm truy cập')

@section('content')
<div class="alert alert-danger mt-4">
    <h2>403 - Bạn không có quyền truy cập chức năng này.</h2>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Quay lại Dashboard</a>
</div>
@endsection
