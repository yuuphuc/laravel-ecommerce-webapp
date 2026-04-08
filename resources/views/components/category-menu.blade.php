<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"    data-bs-toggle="dropdown" aria-expanded="false">
    Danh mục
</a>
<ul class="dropdown-menu dropdown-scrollable" aria-labelledby="navbarDropdown">
    @foreach ($categories as $item)
        <li>
            <a class="dropdown-item" href="{{ route('cate.detail', ['id' => $item->cateid]) }}">
                {{ $item->catename }}
            </a>
        </li>
    @endforeach
</ul>
