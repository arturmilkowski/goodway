<x-layout>
    <x-slot:title>Page</x-slot>
    
        <div>Page:</div>
        <pre>{{ $page }}</pre>
        <div>Content: {{ $page->content }}</div>
</x-layout>
