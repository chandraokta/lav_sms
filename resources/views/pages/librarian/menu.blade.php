{{--Library Management--}}
<li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['books.index', 'books.create', 'books.edit', 'books.show', 'book_requests.index', 'book_requests.create', 'book_requests.edit']) ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link"><i class="icon-books"></i> <span>Library Management</span></a>
    <ul class="nav nav-group-sub" data-submenu-title="Library">
        <li class="nav-item"><a href="{{ route('books.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['books.index', 'books.create', 'books.edit', 'books.show']) ? 'active' : '' }}">Manage Books</a></li>
        <li class="nav-item"><a href="{{ route('book_requests.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['book_requests.index', 'book_requests.create', 'book_requests.edit']) ? 'active' : '' }}">Book Requests</a></li>
    </ul>
</li>