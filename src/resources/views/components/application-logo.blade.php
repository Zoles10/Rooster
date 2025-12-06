{{-- resources/views/components/application-logo.blade.php --}}

@php
    $alt = config('app.name', 'Rooster');
@endphp

<img
    src="{{ asset('images/rooster.png') }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'h-6 w-auto max-h-12 max-w-[168px]']) }}
>
