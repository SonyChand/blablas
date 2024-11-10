<x-auth.header>
    @slot('title')
        {{ $title }}
    @endslot
</x-auth.header>
{{ $slot }}
<x-auth.footer>
    @slot('subtitle')
        {{ $title }}
    @endslot
</x-auth.footer>
