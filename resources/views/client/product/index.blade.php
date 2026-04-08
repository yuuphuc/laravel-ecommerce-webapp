@extends('layout.client')

@section('content')
    <section class="py-5">
        <div class="container">
            <h3 class="mb-4">🛍️ Tất cả sản phẩm</h3>
            <div id="list">
                @include('client.product.partials_list', ['products' => $products])
            </div>
        </div>
    </section>

    <x-ajax-pagination></x-ajax-pagination>
@endsection


