<g clip-path="url(#b2d63091d1)">
    <g />
    </defs>
    @php
        $logoPath = Vite::asset('resources/images/rooster.png');
        $alt = config('app.name', 'Rooster');
    @endphp
    <img src="{{ $logoPath }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => 'h-12 w-auto']) }} />
</g>
