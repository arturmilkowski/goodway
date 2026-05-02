<x-layout>
    <x-slot:title>{{ $post->translation?->title }}</x-slot>

    <div class="max-w-full mx-auto px-4 py-12">
        <article class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-10 text-lg leading-relaxed">
            <h1 class="col-span-full text-balance mb-8 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-3xl">
                {{ $post->translation?->title }}
            </h1>
            @if($post->translation?->intro)
                <p class="mb-6 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                    {{ $post->translation->intro }}
                </p>
            @endif
            <div class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {!! $post->translation?->content !!}
            </div>
        </article>
    </div>

    <x-link-back :href="route('home')" />
</x-layout>