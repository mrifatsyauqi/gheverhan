@props([
    'value' => 0,
    'size' => 'md',
])

@php
    $fullStars = floor($value);
    $halfStar = $value - $fullStars >= 0.5;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    $sizeClass = match($size) {
        'sm' => 'w-3 h-3',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        default => 'w-4 h-4',
    };
@endphp

<div class="flex items-center gap-0.5" aria-label="Rating {{ $value }} out of 5">
    @for($i = 0; $i < $fullStars; $i++)
        <svg class="{{ $sizeClass }} text-yellow-400 fill-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
    @endfor

    @if($halfStar)
        <svg class="{{ $sizeClass }} text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none">
            <defs><clipPath id="half-{{ $value }}"><rect x="0" y="0" width="12" height="24"/></clipPath></defs>
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" clip-path="url(#half-{{ $value }})" fill="currentColor"/>
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
    @endif

    @for($i = 0; $i < $emptyStars; $i++)
        <svg class="{{ $sizeClass }} text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
        </svg>
    @endfor
</div>
