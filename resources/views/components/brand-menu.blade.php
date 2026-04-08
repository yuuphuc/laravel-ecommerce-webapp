<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"    data-bs-toggle="dropdown" aria-expanded="false">
    Thương hiệu
</a>
<ul class="dropdown-menu dropdown-scrollable" aria-labelledby="navbarDropdown">
    @foreach ($brands as $item)
        <li>
            <a class="dropdown-item" href="{{ route('bra.detail', ['id' => $item->id]) }}">
                {{ $item->brandname }}
            </a>
        </li>
    @endforeach
</ul>