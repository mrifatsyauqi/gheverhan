@props([
    'steps' => [],
    'currentStatus' => null,
])

@php
    $statusOrder = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
    $currentIndex = array_search($currentStatus, $statusOrder);

    $statusLabels = [
        'pending' => 'Pesanan Dibuat',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Dikemas',
        'shipped' => 'Dikirim',
        'delivered' => 'Sampai Tujuan',
    ];

    $statusIcons = [
        'pending' => '<path d="M12 3v3m6.366-.366-2.12 2.12M21 12h-3m.366 6.366-2.12-2.12M12 21v-3m-6.366.366 2.12-2.12M3 12h3m-.366-6.366 2.12 2.12"/><circle cx="12" cy="12" r="4"/>',
        'confirmed' => '<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/>',
        'processing' => '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'shipped' => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 13.52 9H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
        'delivered' => '<path d="M5 12h14"/><path d="M12 5l7 7-7 7"/>',
    ];
@endphp

<div class="space-y-0">
    @foreach($statusOrder as $index => $status)
        @php
            $isCompleted = $currentIndex !== false && $index < $currentIndex;
            $isCurrent = $status === $currentStatus;
            $isPending = $currentIndex === false || $index > $currentIndex;

            // Find matching history entry
            $historyEntry = collect($steps)->first(fn ($s) => $s->status === $status);
        @endphp

        <div class="relative flex gap-4 pb-8 last:pb-0">
            {{-- Vertical line --}}
            @if(!$loop->last)
                <div class="absolute left-[15px] top-[32px] w-0.5 h-[calc(100%-32px)] {{ $isCompleted ? 'bg-primary' : ($isCurrent ? 'bg-primary' : 'bg-gray-200') }}"></div>
            @endif

            {{-- Icon --}}
            <div class="relative z-10 flex-shrink-0">
                @if($isCompleted)
                    <div class="w-[30px] h-[30px] rounded-full bg-primary flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                @elseif($isCurrent)
                    <div class="w-[30px] h-[30px] rounded-full bg-primary flex items-center justify-center animate-pulse-dot">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                    </div>
                @else
                    <div class="w-[30px] h-[30px] rounded-full bg-gray-200 flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-gray-400 rounded-full"></div>
                    </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 pt-0.5">
                <h4 class="text-sm font-semibold {{ $isCompleted || $isCurrent ? 'text-primary' : 'text-gray-400' }}">
                    {{ $statusLabels[$status] ?? ucfirst($status) }}
                </h4>
                @if($historyEntry)
                    <p class="text-xs text-gray-500 mt-0.5">{{ $historyEntry->changed_at->format('d M Y, H:i') }}</p>
                    @if($historyEntry->description)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $historyEntry->description }}</p>
                    @endif
                @elseif($isPending)
                    <p class="text-xs text-gray-400 mt-0.5">Menunggu</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
