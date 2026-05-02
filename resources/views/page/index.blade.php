<x-layout>
    <x-slot:title>GoodWay</x-slot>

    <h1 class="mb-4 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
        Aktualności
    </h1>

    <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 mb-16">
@forelse ($posts as $post)
    @php $pt = $post->translation @endphp
    @if($pt)
        <article class="flex flex-col hover:bg-zinc-50">
            <h2 class="border-t border-l border-r border-black px-4 pt-2 font-bold text-xs sm:text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                <a href="{{ route('blog.posts.show', $pt?->slug) }}" title="{{ $pt?->title }}">
                    {{ $pt?->title }}
                </a>
            </h2>
@if ($post->img)
            <picture class="px-4 pt-4">
                <a href="{{ route('blog.posts.show', $pt?->slug) }}" title="{{ $pt?->title }}">
                    <img
                        src="{{ $path }}/{{ $post->img }}"
                        title="{{ $pt?->title }}"
                        class="w-full"
                        @if($post->img1)
                            onmouseover="this.src='{{ $path }}/{{ $post->img1 }}'"
                            onmouseout="this.src='{{ $path }}/{{ $post->img }}'"
                        @endif
                    />
                </a>
            </picture>
@endif
            <p class="px-4 pt-2 my-6 flex-1 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                <a href="{{ route('blog.posts.show', $pt?->slug) }}" title="{{ $pt?->title }}">
                    {{ $pt?->intro }}
                </a>
            </p>
            <div class="mb-6">
                <x-link-forward
                    :href="route('blog.posts.show', $pt?->slug)"
                    :title="$pt?->title"
                    text="Czytaj"
                />
            </div>
            <time
                datetime="{{ $post->created_at->toISOString() }}"
                title="{{ $post->created_at->toFormattedDateString() }}"
                class="mt-auto px-4 pb-2 border-b border-l border-r text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base"
            >
                {{ $post->created_at->format('d.m.Y') }}
            </time>
        </article>
        @endif
@empty
        <p>Brak aktualności</p>
@endforelse
    </article>

    <h1 class="mt-16 mb-4 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">Projekty</h1>

    <article class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
@forelse ($projects as $project)
    @php $prt = $project->translation @endphp
    @if($prt)
        <article class="flex flex-col hover:bg-zinc-50">
            <h2 class="border-t border-l border-r border-black px-4 pt-2 font-bold text-xs sm:text-base md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                <a href="{{ route('projects.show', $prt?->slug) }}" title="{{ $prt?->title }}">
                    {{ $prt?->title }}
                </a>
            </h2>
@if ($project->img)
            <picture class="px-4 pt-4">
                <a href="{{ route('projects.show', $prt?->slug) }}" title="{{ $prt?->title }}">
                    <img
                        src="{{ $path }}/{{ $project->img }}"
                        title="{{ $prt?->title }}"
                        class="w-full"
                        @if($project->img1)
                            onmouseover="this.src='{{ $path }}/{{ $project->img1 }}'"
                            onmouseout="this.src='{{ $path }}/{{ $project->img }}'"
                        @endif
                    />
                </a>
            </picture>
@endif
            <p class="px-4 pt-2 my-6 flex-1 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl 2xl:text-2xl">
                <a href="{{ route('projects.show', $prt?->slug) }}" title="{{ $prt?->title }}">
                    {{ $prt?->intro }}
                </a>
            </p>
            <div class="mb-6">
                <x-link-forward
                    :href="route('projects.show', $prt?->slug)"
                    :title="$prt?->title"
                    text="Czytaj"
                />
            </div>
            <time
                datetime="{{ $project->created_at->toISOString() }}"
                title="{{ $project->created_at->toFormattedDateString() }}"
                class="mt-auto px-4 pb-2 border-b border-l border-r text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base"
            >
                {{ $project->created_at->format('d.m.Y') }}
            </time>
        </article>
        @endif
@empty
        <p>Brak projektów</p>
@endforelse
    </article>

</x-layout>