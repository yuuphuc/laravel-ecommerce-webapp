@extends('layout.client')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<h3 class="mb-4">🔍 Kết quả tìm kiếm cho: <em>{{ $keyword }}</em></h3>

@if ($products->count() > 0)
<div class="row row-cols-1 row-cols-md-4 g-4">
    @foreach ($products as $product)
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
@else
<div class="alert alert-warning text-center">
    Không tìm thấy sản phẩm phù hợp với từ khóa "<strong>{{ $keyword }}</strong>"
</div>
<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 250px;">

</div>
@endif
@endsection