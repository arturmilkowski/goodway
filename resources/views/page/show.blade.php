<x-layout>
    <x-slot:title>{{ $page->translation?->title }}</x-slot>

    <article>
        <h1 class="mb-8 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-3xl">
            {{ $page->translation?->title }}
        </h1>
        @if($page->translation?->intro)
            <p class="mb-6 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {{ $page->translation->intro }}
            </p>
        @endif
        <div class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
            {!! $page->translation?->content !!}
        </div>
    </article>

    <x-link-back :href="route('home')" />
</x-layout>