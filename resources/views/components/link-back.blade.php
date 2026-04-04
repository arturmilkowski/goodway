@props(['href', 'title' => 'Powrót', 'text' => 'Powrót'])

<a href="{{ $href }}" title="{{ $title }}" class="text-xs sm:text-xs md:sm lg:text-base xl:text-lg 2xl:text-xl">
    <x-heroicon-o-arrow-left class="inline-flex items-center w-3 h-3 sm:w-3 sm:h-3 md:w-3 md:h-3 lg:w-4 lg:h-4 xl:w-5 xl:h-5 2xl:w-6 2xl:h-6" /> {{ $text }}
</a>