<x-dash.header>
    {{ $title }}
</x-dash.header>
<x-dash.sidebar></x-dash.sidebar>
<x-dash.navbar>
    {{ Str::lower($title) }}
</x-dash.navbar>

{{ $slot }}
<x-dash.footer>
    @slot('subtitle')
        {{ $title }}
    @endslot
</x-dash.footer>
