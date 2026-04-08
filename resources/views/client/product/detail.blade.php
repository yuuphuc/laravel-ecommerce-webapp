@extends('layout.client')

@section('content')
<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row g-5">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-5">
                <div class="border rounded shadow-sm p-2 bg-white">
                    <img src="{{ asset('storage/products/' . $product->fileName) }}" class="img-fluid rounded" alt="{{ $product->proname }}">
                </div>
            </div>

            <!-- Thông tin chi tiết sản phẩm -->
            <div class="col-md-7">
                <div class="border rounded shadow-sm p-4 bg-white h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h4>{{ $product->proname }}</h4>
                        <h4 class="text-danger fw-bold mb-3">
                            {{ number_format($product->price) }} <span class="text-muted fs-6">VNĐ</span>
                        </h4>
                        <h4>Mô tả:</h4>
                        <p class="text-muted mb-4">{{ $product->description }}</p>
                        <p>Danh mục: {{ $product->category->catename ?? 'Chưa có' }}</p>
                        <p>Thương hiệu: {{ $product->brand->brandname ?? 'Chưa có' }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <form action="{{ route('cartadd', ['id' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ hàng
                            </button>
                        </form>

                        <a href="{{ route('homepage') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-1"></i> Quay về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection