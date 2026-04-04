<x-layout>
        <x-slot:title>GoodWay</x-slot>

        <h1 class="mb-4 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
            Aktualności
        </h1>
        <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 mb-16">
@forelse ($posts as $post)
            <article class="flex flex-col hover:bg-zinc-50">
                <h2 class="border-t border-l border-r border-black px-4 pt-2 font-bold text-xs sm:text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                    <a href="{{ route('blog.posts.show', $post) }}" title="{{ $post->title }}">
                        {{ $post->title }}
                    </a>
                </h2>
@if ($post->img)
                <picture class="px-4 pt-4">
                    <a href="{{ route('blog.posts.show', $post) }}" title="{{ $post->title }}">
                        <img src="{{ $path }}/{{  $post->img }}" class="w-full" title="{{ $post->title }}" />
                    </a>
                </picture>
@endif
                <p class="px-4 pt-2 my-6 flex-1 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                    <a href="{{ route('blog.posts.show', $post) }}" title="{{ $post->title }}">
                        {{ $post->intro }}
                    </a>
                </p>
                {{-- <div class="mb-6">
                    <a
                        href="{{ route('blog.posts.show', $post) }}"
                        title="{{ $post->title }}"
                        class="px-4 py-2 text-xs sm:text-xs md:sm lg:text-base xl:text-lg 2xl:text-xl"
                    >
                        Czytaj
                    </a>
                </div> --}}
                <div class="mb-6">
                    <x-link-forward :href="route('blog.posts.show', $post)"  :title="$post->title" text="Czytaj" />
                </div>
                <time
                    datetime="{{ $post->created_at->toISOString() }}"
                    title="{{ $post->created_at->toFormattedDateString() }}"
                    class="mt-auto px-4 pb-2 border-b border-l border-r text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base"
                >
                    {{ $post->created_at->format('d.m.Y') }}
                </time>
            </article>
@empty
            <p>Brak aktualności</p>
@endforelse
        </article>

        <h1 class="mt-16 mb-4 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">Projekty<h1>
        <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
@forelse ($projects as $project)
            <article class="flex flex-col hover:bg-zinc-50">
                <h2 class="border-t border-l border-r border-black px-4 pt-2 font-bold text-xs sm:text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                    <a href="{{ route('projects.show', $project) }}" title="{{ $project->title }}">
                        {{ $project->title }}
                    </a>
                </h2>
@if ($project->img)
                <picture class="px-4 pt-4">
                    <a href="{{ route('projects.show', $project) }}" title="{{ $project->title }}">
                        <img src="{{ $path }}/{{  $project->img }}" class="w-full" />
                    </a>
                </picture>
@endif
                <p class="px-4 pt-2 my-6 flex-1 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                    <a href="{{ route('projects.show', $project) }}" title="{{ $project->title }}">
                        {{ $project->intro }}
                    </a>
                </p>
                {{-- <div class="mb-6">
                    <a
                        href="{{ route('projects.show', $project) }}"
                        title="{{ $project->title }}"
                        class="px-4 py-2 text-xs sm:text-xs md:sm lg:text-base xl:text-lg 2xl:text-xl"
                    >
                        Czytaj
                    </a>
                </div> --}}
                <div class="mb-6">
                    <x-link-forward :href="route('projects.show', $project)"  :title="$project->title" text="Czytaj" />
                </div>
                <time
                    datetime="{{ $project->created_at->toISOString() }}"
                    title="{{ $project->created_at->toFormattedDateString() }}"
                    class="mt-auto px-4 pb-2 border-b border-l border-r text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base"
                >
                    {{ $project->created_at->format('d.m.Y') }}
                </time>
            </article>
@empty
            <p>Brak projektów</p>
@endforelse
        </article>
</x-layout>
