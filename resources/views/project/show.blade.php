<x-layout>
        <x-slot:title>{{ $project->title }}</x-slot>

        <article>
            <h1 class="mb-8 font-bold text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-3xl">{{ $project->title }}</h1>
            <p class="text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                {!! $project->content !!}
             </p>
        </article>
        <div>
            <a href="{{ route('home') }}" title="Powrót" class="text-xs sm:text-xs md:sm lg:text-base xl:text-lg 2xl:text-xl">
                Powrót
            </a>
        </div>
</x-layout>
