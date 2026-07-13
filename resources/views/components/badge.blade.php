@props([
    'text' => '',
    'variant' => 'default',
])

@php
    $classes = match($variant) {
        'success' => 'bg-green-50 text-green-700',
        'warning' => 'bg-yellow-50 text-yellow-700',
        'danger' => 'bg-red-50 text-red-700',
        'info' => 'bg-blue-50 text-blue-700',
        'primary' => 'bg-primary text-white',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $classes"]) }}>
    {{ $text ?: $slot }}
</span>
