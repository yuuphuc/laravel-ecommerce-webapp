@extends('layout.client')

@section('content')
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">🏷️ Thương hiệu: {{ $brand->brandname }}</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse ($products as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="{{ asset('storage/products/' . $item->fileName) }}" class="card-img-top img-fluid"
                            alt="{{ $item->proname }}" style="object-fit: cover; height: 200px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $item->proname }}</h5>
                            <p class="card-text text-danger fw-bold mb-3">{{ number_format($item->price) }} VNĐ</p>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('detail', ['id' => $item->id]) }}" class="btn btn-outline-dark mt-auto">Chi tiết</a>
                                <form action="{{ route('cartadd', ['id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-dark mt-auto">
                                        <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning text-center">Không có sản phẩm nào thuộc thương hiệu này.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
