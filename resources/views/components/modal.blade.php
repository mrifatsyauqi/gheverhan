@props([
    'name' => 'modal',
    'maxWidth' => 'md',
    'title' => '',
])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        default => 'max-w-md',
    };
@endphp

<div x-data="{ show: false }"
     x-on:open-modal-{{ $name }}.window="show = true"
     x-on:close-modal-{{ $name }}.window="show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    {{-- Backdrop --}}
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="show = false"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Modal Content --}}
    <div class="fixed inset-0 overflow-y-auto flex items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             @click.away="show = false"
             class="relative bg-white rounded-2xl shadow-modal w-full {{ $maxWidthClass }} overflow-hidden">

            {{-- Header --}}
            @if($title)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-primary">{{ $title }}</h3>
                <button @click="show = false" class="p-1 text-gray-400 hover:text-primary transition-colors rounded-lg hover:bg-surface">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
            @endif

            {{-- Body --}}
            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @if(isset($footer))
            <div class="px-6 py-4 border-t border-gray-100 bg-surface/50">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>
