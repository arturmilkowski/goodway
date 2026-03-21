        <header>
            <h1>
                <a href="{{ route('pages.index') }}" title="Strona główna">Good Way</a>
            </h1>
            <nav>
                <ul>
@foreach ($pages as $navPage)
                    <li>
                        <a href="{{ $navPage->slug ? route('pages.show', ['page' => $navPage->slug]) : route('pages.index') }}" title="">
                            {{ $navPage->title }}
                        </a>
                    </li>
@endforeach
                </ul>
                        {{-- <pre>{{ $pages }}</pre> --}}
            </nav>
        </header>