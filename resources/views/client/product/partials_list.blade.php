{{-- partials_list.blade.php --}}
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
    @forelse ($products as $product)
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
                        <a href="{{ route('detail', ['id' => $product->id]) }}" class="btn btn-outline-dark">Chi tiết</a>
                        <form action="{{ route('cartadd', ['id' => $product->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark">
                                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-warning text-center">Không có sản phẩm nào.</div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
