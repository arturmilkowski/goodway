<x-layout>
    <x-slot:title>Page</x-slot>

    <main>
        <div>Page:</div>
        <pre>{{ $page }}</pre>
        <div>Content: {{ $page->content }}</div>
    </main>
</x-layout>