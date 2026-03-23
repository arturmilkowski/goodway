        <header class="flex justify-between border-b border-black">
            <h1 class="text-xs sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-9xl">
                <a href="{{ route('pages.index') }}" title="Strona główna">GoodWay</a>
            </h1>
            <nav class="flex gap-8 text-xs sm:text-xs md:text-sm lg:text-base xl:text-lg 2xl:text-xl">
@foreach ($pages as $navPage)
                <a href="{{ $navPage->slug ? route('pages.show', ['page' => $navPage->slug]) : route('pages.index') }}" title="">
                    {{ $navPage->title }}
                </a>
@endforeach
            </nav>
        </header>
