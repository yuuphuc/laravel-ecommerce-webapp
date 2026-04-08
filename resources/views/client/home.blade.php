@extends('layout.client')

@section('title', 'Trang chủ')

@section('content')
<h2 class="mb-4 text-center">Banner Sản phẩm</h2>
<x-banner-random-product></x-banner-random-product>
<h2 class="mb-4 text-center">Sản phẩm mới</h2>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @foreach ($listpro as $product)
    <div class="col">
        <div class="card h-100 shadow-sm border-0">
            <!-- Product image -->
            <img src="{{ asset('storage/products/' . $product->fileName) }}" class="card-img-top img-fluid"
                alt="{{ $product->proname }}" style="object-fit: cover; height: 200px;">

            <div class="card-body d-flex flex-column">
                <!-- Product name -->
                <h5 class="card-title text-truncate">{{ $product->proname }}</h5>

                <!-- Product price -->
                <p class="card-text text-danger fw-bold mb-3">{{ number_format($product->price) }} VNĐ</p>

                <!-- Product actions -->
                <div class="mt-auto d-flex justify-content-between">
                    <a href="{{ route('detail', ['id' => $product->id]) }}" class="btn btn-outline-dark mt-auto">Chi tiết</a>
                    <!-- Khai bao form cho Chuc nang đat hang -->
                    <form action="{{ route('cartadd', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark mt-auto">
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection