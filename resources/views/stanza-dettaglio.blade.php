<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room->name }} - Cà Scirocco</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($room->description ?? ''), 150) }}">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}?v={{ time() }}">
    @livewireStyles
</head>
<body class="bg-stone-50 text-stone-900 antialiased">
    @php
        $images = is_array($room->images ?? null) ? array_values(array_filter($room->images)) : [];
        $amenities = is_array($room->amenities ?? null) ? $room->amenities : [];
        $fallbackImage = asset('images/logo_nero.png');

        $resolveImageUrl = static function (?string $path) use ($fallbackImage): string {
            if (! filled($path)) {
                return $fallbackImage;
            }

            $cleanPath = ltrim($path, '/');

            return \Illuminate\Support\Str::startsWith($cleanPath, 'images/')
                ? asset($cleanPath)
                : asset('storage/' . $cleanPath);
        };

        $mainImage = count($images) > 0 ? $resolveImageUrl($images[0]) : $fallbackImage;
    @endphp

    <nav class="sticky top-0 left-0 w-full z-40 bg-white border-b border-stone-100 px-6 py-3">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo_nero.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="text-lg font-serif font-bold text-stone-900 uppercase tracking-tighter">Cà Scirocco</span>
            </a>
            <a href="{{ url('/#alloggi') }}" class="text-[10px] uppercase tracking-[0.2em] font-bold text-stone-600 hover:text-amber-700">Alloggi</a>
        </div>
    </nav>

    <main class="min-h-screen">
        <section class="relative h-[38vh] min-h-[280px] bg-stone-900 overflow-hidden">
            <img src="{{ $mainImage }}" alt="{{ $room->name }}" class="w-full h-full object-cover opacity-65">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 w-full max-w-6xl px-4 md:px-6">
                <span class="text-amber-500 uppercase tracking-[0.35em] text-[10px] font-bold block mb-2">Dettaglio Alloggio</span>
                <h1 class="text-3xl md:text-5xl text-white font-serif italic">{{ $room->name }}</h1>
            </div>
        </section>

        <section class="py-8 md:py-10">
            <div class="max-w-6xl mx-auto px-4 md:px-6">
                <a href="{{ url('/#alloggi') }}" class="inline-flex items-center text-xs uppercase tracking-[0.2em] text-stone-500 hover:text-amber-700 mb-6">
                    ← Torna agli alloggi
                </a>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 bg-white border border-stone-200 shadow-sm p-4 md:p-8">
                    <div x-data="{ active: '{{ $mainImage }}' }">
                        <div class="aspect-[4/3] bg-stone-100 overflow-hidden">
                            <img :src="active" alt="{{ $room->name }}" class="w-full h-full object-cover">
                        </div>

                        @if(count($images) > 1)
                            <div class="grid grid-cols-4 gap-3 mt-3">
                                @foreach($images as $image)
                                    @php $imageUrl = $resolveImageUrl($image); @endphp
                                    <button type="button" @click="active = '{{ $imageUrl }}'" class="aspect-square overflow-hidden border border-stone-200 hover:border-amber-700">
                                        <img src="{{ $imageUrl }}" alt="{{ $room->name }} foto" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-stone-700 mb-6">
                            <p><span class="font-semibold">Prezzo a notte:</span> EUR {{ number_format((float) ($room->price_per_night ?? 0), 2, ',', '.') }}</p>
                            <p><span class="font-semibold">Capacita:</span> {{ $room->capacity ?? '-' }} ospiti</p>
                            <p><span class="font-semibold">Dimensione:</span> {{ $room->size_sqm ? $room->size_sqm . ' m²' : '-' }}</p>
                            <p><span class="font-semibold">Letto:</span> {{ $room->bed_type ?? '-' }}</p>
                            <p><span class="font-semibold">Bagno:</span> {{ $room->bathroom_type ?? '-' }}</p>
                            <p><span class="font-semibold">Codice stanza:</span> #{{ $room->id }}</p>
                        </div>

                        <div class="border-t border-stone-200 pt-5 mb-8">
                            <h2 class="text-xs uppercase tracking-[0.2em] text-stone-500 mb-3">Descrizione</h2>
                            <p class="text-stone-700 leading-relaxed">
                                {{ $room->description ?: 'Descrizione non disponibile al momento.' }}
                            </p>
                        </div>

                        @if(count($amenities) > 0)
                            <div class="border-t border-stone-200 pt-5 mb-8">
                                <h2 class="text-xs uppercase tracking-[0.2em] text-stone-500 mb-3">Servizi inclusi</h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($amenities as $amenity)
                                        <span class="px-3 py-1 text-[10px] uppercase tracking-[0.15em] bg-stone-100 border border-stone-200 text-stone-700">{{ $amenity }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-auto flex flex-col sm:flex-row gap-3">
                            <a href="{{ url('/#alloggi') }}" class="px-5 py-3 border border-stone-300 text-center text-xs uppercase tracking-[0.2em] hover:bg-stone-100">Altri alloggi</a>
                            <a href="{{ url('/#prenota-tavolo') }}" class="px-5 py-3 bg-stone-900 text-white text-center text-xs uppercase tracking-[0.2em] hover:bg-amber-800">Prenota Tavolo</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-stone-950 text-white pt-14 pb-8">
        <div class="max-w-6xl mx-auto px-4 md:px-6">
            <div class="flex justify-center gap-8 mb-10 text-[10px] uppercase tracking-[0.25em] text-stone-400">
                <a href="https://www.facebook.com" target="_blank" class="hover:text-white transition">Facebook</a>
                <a href="https://www.instagram.com" target="_blank" class="hover:text-white transition">Instagram</a>
                <a href="https://www.tripadvisor.it" target="_blank" class="hover:text-white transition">TripAdvisor</a>
            </div>
            <div class="pt-6 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] uppercase tracking-[0.2em] text-stone-500">
                <div class="flex gap-6">
                    <a href="{{ route('privacy') }}" class="hover:text-amber-600 transition">Privacy</a>
                    <a href="{{ route('cookies') }}" class="hover:text-amber-600 transition">Cookie</a>
                    <a href="{{ route('terms') }}" class="hover:text-amber-600 transition">Termini</a>
                </div>
                <span>&copy; {{ date('Y') }} Cà Scirocco</span>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
