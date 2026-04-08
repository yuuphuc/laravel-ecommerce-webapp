@if ($products->count() > 0)
<div id="randomProductCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="2000">
    <div class="carousel-inner">
        @foreach($products->chunk(4) as $chunkIndex => $chunk)
        <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($chunk as $product)
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="{{ asset('storage/products/' . $product->fileName) }}" class="card-img-top img-fluid"
                                alt="{{ $product->proname }}" style="object-fit: cover; height: 200px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ $product->proname }}</h5>
                                <p class="card-text text-danger fw-bold mb-3">{{ number_format($product->price) }} VNĐ</p>
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
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#randomProductCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#randomProductCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
@endif
