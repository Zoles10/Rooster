<g clip-path="url(#b2d63091d1)">
    <g />
    </defs>
    @php
        $logoPath = Vite::asset('resources/images/rooster.png');
        $alt = config('app.name', 'Rooster');
    @endphp
    <img src="{{ $logoPath }}" alt="{{ $alt }}"
        {{ $attributes->merge(['class' => 'h-6 w-auto max-h-12 max-w-[168px]']) }} />
</g>
