<x-layout>
        <x-slot:title>{{ $page->title }}</x-slot>
    
        <article>
            <h1 class="mb-8 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-3xl">{{ $page->title }}</h1>
            <p class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {!! $page->content !!}
             </p>
        </article>
        <x-link-back :href="route('home')" />
</x-layout>
