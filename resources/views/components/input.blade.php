@props([
    'label' => null,
    'type' => 'text',
    'name',
    'error' => null,
    'hint' => null,
    'icon' => null,
    'required' => false,
])

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-primary mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-400">{!! $icon !!}</span>
            </div>
        @endif

        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->except('class')->merge([
                'class' => 'w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-primary
                           placeholder-gray-400 transition-all duration-200
                           focus:border-primary focus:ring-2 focus:ring-primary/10 focus:outline-none
                           disabled:bg-surface disabled:cursor-not-allowed'
                           . ($icon ? ' pl-10' : '')
                           . ($error ? ' border-red-400 focus:border-red-500 focus:ring-red-100' : '')
            ]) }}
        >
    </div>

    @if($error)
        <p class="mt-1 text-xs text-red-500">{{ $error }}</p>
    @elseif($hint)
        <p class="mt-1 text-xs text-gray-400">{{ $hint }}</p>
    @endif
</div>
