@props([
    'type' => 'success',
    'dismissible' => true,
])

@php
    $config = match($type) {
        'success' => ['bg' => 'bg-green-50 border-green-200', 'text' => 'text-green-800', 'icon' => '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>'],
        'error' => ['bg' => 'bg-red-50 border-red-200', 'text' => 'text-red-800', 'icon' => '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>'],
        'warning' => ['bg' => 'bg-yellow-50 border-yellow-200', 'text' => 'text-yellow-800', 'icon' => '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>'],
        'info' => ['bg' => 'bg-blue-50 border-blue-200', 'text' => 'text-blue-800', 'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>'],
        default => ['bg' => 'bg-gray-50 border-gray-200', 'text' => 'text-gray-800', 'icon' => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>'],
    };
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
     {{ $attributes->merge(['class' => "flex items-start gap-3 p-4 rounded-lg border {$config['bg']} {$config['text']}"]) }}>
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        {!! $config['icon'] !!}
    </svg>
    <div class="flex-1 text-sm">{{ $slot }}</div>
    @if($dismissible)
        <button @click="show = false" class="flex-shrink-0 p-1 rounded hover:bg-black/5 transition-colors">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
        </button>
    @endif
</div>
