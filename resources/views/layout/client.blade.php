<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Trang chủ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .site-header {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
        }

        .site-footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .dropdown-scrollable {
            max-height: 300px;
            /* hoặc bất kỳ chiều cao nào bạn muốn */
            overflow-y: auto;
        }
    </style>
</head>

<body>

    {{-- Navigation --}}
    <nav class="site-header sticky-top py-1">
        <div class="container d-flex align-items-center justify-content-between">
            {{-- Logo / Tên website --}}
            <a href="{{ route('homepage') }}" class="text-white fs-5 fw-bold text-decoration-none">MyShop</a>

            {{-- Menu --}}
            <div class="d-flex gap-3">
                <a href="{{ route('homepage') }}" class="text-white text-decoration-none">Trang chủ</a>
                <a href="{{ route('list') }}" class="text-white text-decoration-none">Sản phẩm</a>
                <a class="nav-item dropdown">
                    <!-- gọi component -->
                    <x-category-menu></x-category-menu>
                </a>
                <a class="nav-item dropdown">
                    <!-- gọi component -->
                    <x-brand-menu></x-brand-menu>
                </a>
                <a href="#" class="text-white text-decoration-none">Liên hệ</a>
                <form action="{{ route('search') }}" method="GET" class="d-flex ms-3">
                    <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Tìm sản phẩm..." required>
                    <button class="btn btn-outline-light btn-sm ms-2" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>

            {{-- Giỏ hàng --}}
            <div class="d-flex align-items-center gap-2">
                {{-- THÊM: Nút vào trang admin, chỉ hiện nếu là admin đang login --}}
                @if(Auth::check())
                <a href="{{ route('dashboard') }}"
                    class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                    <i class="bi bi-speedometer2"></i>
                    <span>Trang Admin</span>
                </a>
                @endif
                <a class="btn btn-outline-light position-relative d-flex align-items-center gap-2" href="{{ route('cartshow') }}">
                    <i class="bi bi-cart4 fs-5"></i>
                    <span>Giỏ hàng</span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ count(Session::get('cart', [])) }}
                        <span class="visually-hidden">sản phẩm trong giỏ</span>
                    </span>
                </a>
            </div>

        </div>
    </nav>

    {{-- Header --}}
    <header class="site-header text-center">
        <div class="container">
            <h1 class="display-5">Chào mừng đến với Website bán hàng</h1>
            <p class="lead">Sản phẩm chất lượng, giá cả hợp lý</p>
        </div>
    </header>

    {{-- Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="site-footer text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} MyShop. All rights reserved.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.btn-increase, .btn-decrease').click(function(e) {
            e.preventDefault();

            let productid = $(this).data('id');
            let action = $(this).hasClass('btn-increase') ? 'increase' : 'decrease';

            $.ajax({
                url: '{{ route("cartupdate") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    productid: productid,
                    action: action
                },
                success: function(response) {
                    if (response.success) {
                        if (response.removed) {
                            location.reload();
                        } else {
                            $('#qty-' + productid).text(response.quantity); // số lượng
                            $('#subtotal-' + productid).text(response.subtotal + ' VNĐ'); // thành tiền (theo dòng)
                            $('#total-amount').text(response.total + ' VNĐ'); // tổng tiền toàn bộ
                        }
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('js/navigate.js') }}"></script>

</body>

</html>