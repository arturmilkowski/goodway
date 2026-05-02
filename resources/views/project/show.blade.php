<x-layout>
    <x-slot:title>{{ $project->translation?->title }}</x-slot>

    <article>
        <h1 class="mb-8 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-3xl">
            {{ $project->translation?->title }}
        </h1>
        @if($project->translation?->intro)
            <p class="mb-6 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {{ $project->translation->intro }}
            </p>
        @endif
        @if($project->translation?->content)
            <div class="mb-8 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {!! $project->translation->content !!}
            </div>
        @endif
        @if($project->translation?->result)
            <h2 class="mb-4 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                Rezultat
            </h2>
            <div class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {!! $project->translation->result !!}
            </div>
        @endif
    </article>

    <x-link-back :href="route('home')" />
</x-layout>