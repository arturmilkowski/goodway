        <header class="pb-18 flex justify-between">
            <h1 class="text-xs sm:text-xs md:text-xl lg:text-3xl xl:text-7xl 2xl:text-9xl">
                <a href="{{ route('home') }}" title="Strona główna">
                    GoodWay
                </a>
            </h1>
            <nav class="flex gap-8 text-xs sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
@foreach ($pages as $navPage)
                <a href="{{ $navPage->slug ? route('pages.show', ['page' => $navPage->slug]) : route('home') }}" title="{{ $navPage->intro }}">
                    {{ $navPage->title }}
                </a>
@endforeach
            </nav>
        </header>
