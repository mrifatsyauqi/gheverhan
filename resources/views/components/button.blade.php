@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'fullWidth' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = match($variant) {
        'primary' => 'bg-primary text-white hover:bg-gray-800 focus:ring-primary active:scale-[0.98]',
        'secondary' => 'border-2 border-primary text-primary bg-transparent hover:bg-primary hover:text-white focus:ring-primary',
        'ghost' => 'text-gray-600 hover:text-primary hover:bg-surface focus:ring-gray-300',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        default => 'bg-primary text-white hover:bg-gray-800 focus:ring-primary',
    };

    $sizeClasses = match($size) {
        'sm' => 'px-4 py-2 text-xs gap-1.5',
        'md' => 'px-6 py-2.5 text-sm gap-2',
        'lg' => 'px-8 py-3 text-base gap-2',
        'xl' => 'px-10 py-3.5 text-base gap-2.5',
        default => 'px-6 py-2.5 text-sm gap-2',
    };

    $widthClass = $fullWidth ? 'w-full' : '';

    $classes = "$baseClasses $variantClasses $sizeClasses $widthClass";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif
