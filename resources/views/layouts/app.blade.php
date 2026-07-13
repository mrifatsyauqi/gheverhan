<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? 'GHEVERHAN - Elevate Your Everyday Style. Premium fashion e-commerce platform.' }}">

    <title>{{ $title ?? 'GHEVERHAN' }} | Elevate Your Everyday Style</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-primary min-h-screen flex flex-col">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="fixed top-4 right-4 z-50 bg-primary text-white px-6 py-3 rounded-lg shadow-modal text-sm font-medium animate-slide-down">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-modal text-sm font-medium animate-slide-down">
            {{ session('error') }}
        </div>
    @endif

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Main Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Mobile Bottom Navigation --}}
    @include('layouts.partials.mobile-nav')

    {{-- Bottom spacer for mobile nav --}}
    <div class="mobile-nav-spacer"></div>
</body>
</html>
