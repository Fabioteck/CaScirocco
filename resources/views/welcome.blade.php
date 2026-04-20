<!DOCTYPE html>
<html lang="it" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cà Scirocco - Ristorante e Alloggi ad Adria</title>
    
    <meta name="description" content="Cà Scirocco: Ristorante e alloggi nel cuore del Delta del Po. Sapori autentici e camere immerse nel silenzio della natura tra Adria e Loreo.">
    <meta name="keywords" content="Cà Scirocco, agriturismo adria, ristorante rovigo, alloggi delta del po, dormire adria">
    <meta name="author" content="Frigeri Fabio">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo_nero.png') }}">

    <!-- Scripts & Assets -->
    <!-- <script src="{{ asset('lib/tailwind/tailwind.js') }}"></script> -->
    <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/all.min.css') }}?v=1.2">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}?v={{ time() }}">
    <!-- CSS Personalizzato Cà Scirocco -->
    <link rel="stylesheet" href="{{ asset('css/scirocco.css') }}?v={{ time() }}">


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

@livewireStyles
</head>

<body class="bg-stone-50 text-stone-900 antialiased">

@php
    $oggi = \Carbon\Carbon::today();
    $inizioFerie = $settings->get('ferie_inizio') ? \Carbon\Carbon::parse($settings->get('ferie_inizio')) : null;
    $fineFerie = $settings->get('ferie_fine') ? \Carbon\Carbon::parse($settings->get('ferie_fine')) : null;
    
    $chiusoTotale = $settings->get('chiusura_totale') === '1';
    $inFerie = ($inizioFerie && $fineFerie && $oggi->between($inizioFerie, $fineFerie));
@endphp

{{-- Banner Avviso Chiusura --}}
@if($chiusoTotale || $inFerie)
    <div class="bg-red-700 text-white text-center py-3 px-4 sticky top-0 z-[70] font-bold shadow-2xl border-b border-white/20 backdrop-blur-md">
        <div class="flex items-center justify-center gap-3 text-sm md:text-base">
            @if($chiusoTotale)
                <span class="animate-pulse">🚨</span> AVVISO: Prenotazioni online sospese. Contattaci telefonicamente.
            @else
                <span>🏖️</span> Saremo chiusi per ferie dal {{ $inizioFerie->format('d/m') }} al {{ $fineFerie->format('d/m') }}.
            @endif
        </div>
    </div>
@endif

<!-- NAVIGAZIONE FISSA: LINK VISIBILI SU PC + HAMBURGER SU MOBILE -->
<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full z-50 bg-white border-b border-stone-100 px-6 py-3">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
        
        <!-- LOGO E NOME -->
        <a href="{{ url('/') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo_nero.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="text-lg font-serif font-bold text-stone-900 uppercase tracking-tighter">Cà Scirocco</span>
        </a>
        
        <!-- MENU DESKTOP: QUESTO È QUELLO CHE MANCAVA (VISIBILE DA 1024px IN SU) -->
        <div class="hidden lg:flex items-center gap-8 text-[10px] font-bold uppercase tracking-widest text-stone-600">
            <a href="#ristorante" class="hover:text-amber-700 transition">Ristorante</a>
            <a href="#alloggi" class="hover:text-amber-700 transition">Alloggi</a>
            <a href="#staff" class="hover:text-amber-700 transition">Staff</a>
            <a href="#contatti" class="hover:text-amber-700 transition">CONTATTI</a>
            <a href="#prenota-tavolo" class="bg-stone-950 text-white px-5 py-2 text-[9px] hover:bg-amber-800 transition ml-4">
                PRENOTA TAVOLO
            </a>
        </div>

        <!-- TASTO HAMBURGER (VISIBILE SOLO SOTTO I 1024px) -->
        <div class="lg:hidden flex items-center">
            <button @click="open = !open" class="text-stone-900 p-2 focus:outline-none">
                <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- MENU MOBILE (DROPDOWN) -->
    <div x-show="open" x-transition class="lg:hidden bg-white border-t border-stone-100 mt-3 py-6 flex flex-col gap-6 text-center text-[11px] font-bold uppercase tracking-widest text-stone-600" style="display:none;">
        <a href="#" @click="open = false">Ristorante</a>
        <a href="#" @click="open = false">Alloggi</a>
        <a href="#" @click="open = false">Staff</a>
        <a href="#" @click="open = false">Eventi</a>
        <a href="#prenota-tavolo" @click="open = false" class="mx-10 bg-stone-950 text-white py-3">PRENOTA TAVOLO</a>
    </div>
</nav>

<script>
  (function () {
    const setNavHeight = () => {
      const nav = document.querySelector('nav');
      if (!nav) return;
      const h = Math.round(nav.getBoundingClientRect().height || 72);
      document.documentElement.style.setProperty('--nav-h', h + 'px');
    };
    window.addEventListener('load', setNavHeight, { passive: true });
    window.addEventListener('resize', setNavHeight, { passive: true });
  })();
</script>

<!-- HEADER CON FRECCIA BIANCA -->
<header class="relative h-screen w-full flex items-center justify-center overflow-hidden bg-stone-900">
    <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover opacity-60 z-0">
        <source src="{{ asset('videos/hero-cascirocco.mp4') }}" type="video/mp4">
    </video>
    
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black/70 z-[1]"></div>

    <div class="relative z-10 text-center px-6 max-w-5xl pt-20">
        <span class="text-amber-500 uppercase tracking-[0.5em] text-[10px] font-bold mb-4 block">Tenuta Veneta dal 1800</span>
        <h1 class="text-5xl md:text-7xl text-white font-bold mb-6 tracking-tight italic font-serif drop-shadow-2xl">Cà Scirocco</h1>
        <div class="w-16 h-[1px] bg-amber-600 mx-auto mb-8"></div>
        <p class="text-lg md:text-xl text-stone-100 mb-12 italic font-light max-w-2xl mx-auto leading-relaxed">
            Sapori autentici e riposo nel silenzio della natura nel cuore del Delta del Po
        </p>
        
        <div class="flex flex-col sm:flex-row gap-5 justify-center items-center mb-16">
            <a href="tel:+39042622417" class="w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/40 text-white px-12 py-5 hover:bg-white hover:text-stone-950 transition-all duration-300 uppercase tracking-widest text-[11px] font-bold">Chiamaci</a>    
            <a href="#prenota-tavolo" class="w-full sm:w-auto bg-amber-700 text-white px-12 py-5 hover:bg-amber-800 transition-all duration-300 uppercase tracking-widest text-[11px] font-bold shadow-2xl">Prenota Tavolo</a>
            <a href="#alloggi" class="w-full sm:w-auto bg-white/10 backdrop-blur-md border border-white/40 text-white px-12 py-5 hover:bg-white hover:text-stone-950 transition-all duration-300 uppercase tracking-widest text-[11px] font-bold">Prenota Stanza</a>
        </div>
    </div>

    <!-- FRECCIA BIANCA (CORRETTA) -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce">
        <svg class="w-8 h-8 text-white stroke-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</header>


<!-- SEZIONE RISTORANTE -->
<section id="ristorante" class="section-shell bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-10">
            <span class="text-amber-700 uppercase tracking-[0.4em] text-[10px] font-bold block mb-4">Esperienza Culinaria</span>
    
            <h2 class="text-center font-serif italic text-3xl md:text-4xl text-gray-800 mb-8">
                Dalla terra alla tavola
            </h2>
        </div>

       <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Menu Digitale del giorno -->
             <a href="{{ url('/menu-digitale') }}" class="tuo-stile-bottone">
            <div class="group relative overflow-hidden aspect-[3/4] shadow-2xl bg-stone-200">
                <img src="{{ asset('images/ristorante/secondi.jpg') }}" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out" alt="Secondi di Carne">
                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/20 to-transparent flex flex-col justify-end p-8">
                    <span class="text-amber-500 text-[10px] uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Offerta del Giorno</span>
                    <h3 class="text-white text-3xl font-serif italic">Menu del Giorno</h3>
                    <p class="text-stone-300 text-sm italic mt-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Esplora il nostro menu digitale</p>
                </div>
            </div>
            </a>

            <!-- Menu' Stagionale -->
             <a href="{{ url('/il-menu') }}" class="tuo-stile-bottone">
                <div class="group relative overflow-hidden aspect-[3/4] shadow-2xl bg-stone-200">
                    <img src="{{ asset('images/ristorante/primi.jpg') }}" 
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out" alt="Primi Piatti Cà Scirocco">
                    <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/20 to-transparent flex flex-col justify-end p-8">
                        <span class="text-amber-500 text-[10px] uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Tradizione Veneta</span>
                        <h3 class="text-white text-3xl font-serif italic">Menu' Stagionale</h3>
                        <p class="text-stone-300 text-sm italic mt-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Piatti della tradizione veneta</p>
                    </div>
                </div>
            </a>

            <!-- Cantina -->
            <a href="{{ url('/cantina') }}" class="tuo-stile-bottone">
            <div class="group relative overflow-hidden aspect-[3/4] shadow-2xl bg-stone-200">
                <img src="{{ asset('images/ristorante/cantina.jpg') }}" 
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 ease-out" alt="Cantina Cà Scirocco">
                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-950/20 to-transparent flex flex-col justify-end p-8">
                    <span class="text-amber-500 text-[10px] uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Selezione del Territorio</span>
                    <h3 class="text-white text-3xl font-serif italic">La Cantina</h3>
                    <p class="text-stone-300 text-sm italic mt-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">Eccellenze locali e vitigni autoctoni</p>
                </div>
            </div>
            </a>
        </div>
    </div>
</section>

<!-- PRENOTA TAVOLO -->
<section id="prenota-tavolo" class="section-shell bg-stone-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-stone-50 p-8 md:p-16 border border-stone-100 shadow-sm relative overflow-hidden">
            {{-- Elemento decorativo --}}
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i class="fa-solid fa-utensils text-9xl"></i>
            </div>

            <div class="text-center mb-12 relative z-10">
                <span class="text-amber-700 text-[10px] uppercase tracking-[0.4em] font-bold">Booking Online</span>
                <h2 class="text-4xl font-serif italic text-stone-800 mt-4">Prenota un Tavolo</h2>
                <p class="text-stone-500 mt-4 text-sm font-light">Un'esperienza sensoriale ti aspetta a Cà Scirocco</p>
            </div>
            
            <div class="relative z-10">
                @livewire('restaurant-booking-form')
            </div>
        </div>
    </div>
</section>

<!-- SEZIONE ALLOGGI -->
<section id="alloggi" class="section-shell bg-stone-50/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div >
                <span class="text-amber-700 uppercase tracking-[0.4em] text-[10px] font-bold block mb-4">Ospitalità</span>
               <h2 class="text-4xl font-serif italic text-stone-800 mt-4">I Nostri Alloggi</h2>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($rooms as $room)
            <div class="group bg-white border border-stone-200/60 transition-all duration-500 hover:shadow-2xl flex flex-col h-full">
                
                {{-- Immagine dinamica da storage --}}
                <div class="aspect-[4/5] overflow-hidden relative bg-stone-100">
                    @php
                        $roomImage = is_array($room->images ?? null) && count($room->images) > 0 ? $room->images[0] : null;
                        $roomImagePath = ltrim((string) $roomImage, '/');
                        $roomImageUrl = $roomImage
                            ? (\Illuminate\Support\Str::startsWith($roomImagePath, 'images/') ? asset($roomImagePath) : asset('storage/' . $roomImagePath))
                            : asset('images/logo_nero.png');
                        $roomPrice = $room->price ?? $room->price_per_night;
                        $roomDetailUrl = filled($room->slug ?? null)
                            ? route('alloggi.show', $room->slug)
                            : route('stanza.show', $room->id);
                    @endphp
                    
                    <a href="{{ $roomDetailUrl }}" class="block h-full w-full">
                        <img src="{{ $roomImageUrl }}"
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" 
                             alt="{{ $room->name }}">
                    </a>
                    
                    <div class="absolute top-0 left-0 w-full h-full bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>

                    <div class="absolute bottom-6 left-0 w-full px-6 flex justify-between items-center translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                        <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 text-[9px] font-bold tracking-widest uppercase text-stone-900 shadow-xl">
                            Da €{{ number_format((float) $roomPrice, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Contenuto Descrittivo --}}
                <div class="p-8 flex-grow flex flex-col text-center">
                    <h4 class="text-lg font-serif uppercase tracking-wider text-stone-800 mb-2">
                        <a href="{{ $roomDetailUrl }}">{{ $room->name }}</a>
                    </h4>
                    <p class="text-stone-400 text-[10px] uppercase tracking-[0.2em] mb-8 font-medium">Comfort & Tradizione</p>
                    
                    <div class="mt-auto">
                        <a href="{{ $roomDetailUrl }}" class="tuo-stile-bottone">
                        <button class="w-full bg-stone-900 text-white py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-amber-800 transition-all duration-300">
                            Verifica Disponibilità
                        </button>
                        </a>
                    </div>
                </div>
            </div>
            
            @empty
            <div class="col-span-full text-center py-12 bg-white border border-stone-200/60">
                <p class="text-stone-500 uppercase tracking-[0.2em] text-[10px]">Alloggi in aggiornamento</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- SEZIONE GALLERIA -->
<section id="galleria" class="section-shell bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12">
            <span class="text-amber-700 uppercase tracking-[0.4em] text-[10px] font-bold block mb-4">Atmosfera</span>
            <h2 class="text-4xl font-serif italic text-stone-800">Galleria</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galleries as $gallery)
                @php
                    $galleryImageUrl = filled($gallery->image_path)
                        ? asset('storage/' . ltrim($gallery->image_path, '/'))
                        : asset('images/logo_nero.png');
                @endphp
                <div class="overflow-hidden bg-stone-100">
                    <img
                        src="{{ $galleryImageUrl }}"
                        alt="{{ $gallery->title ?? 'Galleria Cà Scirocco' }}"
                    >
                </div>
            @empty
                <div class="col-span-full text-center py-12 border border-stone-200">
                    <p class="text-stone-500 uppercase tracking-[0.2em] text-[10px]">Galleria in aggiornamento</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
    
@if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('status') }}
    </div>
@endif
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
        <p class="font-bold">Disponibile!</p>
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm" role="alert">
        <p class="font-bold">Occupata</p>
        <p>{{ session('error') }}</p>
    </div>
@endif


<!-- SEZIONE STAFF -->
<section id="staff" class="section-shell bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <span class="text-amber-700 uppercase tracking-[0.5em] text-[10px] font-bold block mb-4">L'anima di Cà Scirocco</span>
        <h2 class="text-5xl font-serif italic text-stone-800 mb-8">Il Nostro Staff</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-20">
            <!-- Membro 1 -->
            <div class="group cursor-default">
                <div class="relative overflow-hidden aspect-[4/5] mb-8 shadow-2xl bg-stone-200">
                    <img src="{{ asset('images/staff/chef.jpg') }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-in-out" alt="Executive Chef">
                </div>
                <h4 class="text-2xl font-serif italic text-stone-900">Mirko Zanella</h4>
                <p class="text-amber-800 uppercase tracking-[0.3em] text-[10px] font-bold mt-3">Executive Chef</p>
            </div>

            <!-- Membro 2 -->
            <div class="group cursor-default">
                <div class="relative overflow-hidden aspect-[4/5] mb-8 shadow-2xl bg-stone-200">
                    <img src="{{ asset('images/staff/sommelier.jpg') }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-in-out" alt="Sommelier">
                </div>
                <h4 class="text-2xl font-serif italic text-stone-900">Giulio Bianchi</h4>
                <p class="text-amber-800 uppercase tracking-[0.3em] text-[10px] font-bold mt-3">Sommelier & Cantina</p>
            </div>

            <!-- Membro 3 -->
            <div class="group cursor-default">
                <div class="relative overflow-hidden aspect-[4/5] mb-8 shadow-2xl bg-stone-200">
                    <img src="{{ asset('images/staff/accoglienza.jpg') }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-in-out" alt="Responsabile Ospitalità">
                </div>
                <h4 class="text-2xl font-serif italic text-stone-900">Staff Accoglienza</h4>
                <p class="text-amber-800 uppercase tracking-[0.3em] text-[10px] font-bold mt-3">Responsabile Ospitalità</p>
            </div>
        </div>
    </div>
</section>

<!-- SEZIONE MAPPA STATICA -->
<section id="posizione" class="relative h-[500px] w-full overflow-hidden flex items-center">
    
    <!-- Immagine Statica di Sfondo (Scalabile come il video) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/mappa.png') }}" 
             alt="Mappa Cà Scirocco Adria" 
             class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
        <!-- Overlay leggero per far risaltare il box -->
        <div class="absolute inset-0 bg-stone-900/10"></div>
    </div>

 <!-- BOX INFO AGGIORNATO -->
<div class="relative z-30 container mx-auto px-20">
    <div class="bg-white shadow-2xl p-8 md:p-12 max-w-sm border border-stone-100">
        <span class="text-amber-700 uppercase tracking-[0.3em] text-[10px] font-bold block mb-4">
            La nostra posizione
        </span>
        
        <h2 class="font-serif text-4xl text-stone-900 mb-6 italic">Cà Scirocco</h2>
        
        <div class="w-12 h-[1px] bg-amber-600 mb-8"></div>

        <!-- LISTA CONTATTI DIRETTI -->
        <div class="space-y-6 text-stone-500 text-[10px] tracking-[0.2em] uppercase font-bold">
            
            <!-- POSIZIONE -->
            <div class="flex flex-col gap-1">
                <span class="text-stone-400 text-[9px]">Indirizzo</span>
                <p class="text-stone-900">Via Scirocco, 12 - 45011 Adria (RO)</p>
            </div>


        <!-- BOTTONI AZIONE -->
        <div class="mt-10 flex flex-col gap-3">
            <!-- GOOGLE MAPS -->
            <a href="https://maps.app.goo.gl" 
               target="_blank" 
               class="w-full bg-stone-900 text-white text-center py-4 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-stone-800 transition-colors">
                Ottieni Indicazioni
            </a>

            <!-- WHATSAPP -->
            <a href="https://wa.me" 
               target="_blank" 
               class="w-full border border-green-600 text-green-600 text-center py-4 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-green-600 hover:text-white transition-all">
                Scrivici su WhatsApp
            </a>

            <!-- EMAIL -->
            <a href="mailto:info@cascirocco.it" 
               target="_blank" 
               class="w-full border border-green-600 text-green-600 text-center py-4 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-green-600 hover:text-white transition-all">
                Mandaci una mail
            </a>

            <!-- CHIAMACI -->
            <a href="tel:+39042622417" 
               target="_blank" 
               class="w-full border border-green-600 text-green-600 text-center py-4 text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-green-600 hover:text-white transition-all">
                Chiamaci ora
            </a>
        </div>
    </div>
</div>

</section>

<!-- SEZIONE SOCIAL & FOOTER INTEGRATA -->
<<!-- FOOTER CON UNICO CERVELLO ALPINE.JS -->
<footer x-data="{ 
    legalModal: null, 
    cookieConsent: localStorage.getItem('cookie_consent') === null 
}" class="bg-stone-950 text-white pt-20 pb-10">
    
    <div class="max-w-7xl mx-auto px-4">
        <!-- Social Network -->
        <div class="flex flex-col items-center mb-16">
            <span class="text-amber-700 uppercase tracking-[0.5em] text-[10px] font-bold block mb-4">Rimani Connesso</span>
            <h2 class="text-5xl font-serif italic text-white mb-16 text-center">Social Network</h2>
            <div class="flex flex-wrap justify-center gap-8 md:gap-12">
                  <!-- Facebook -->
                <a href="https://www.facebook.com/www.cascirocco.it" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-white transition-all duration-500 shadow-xl">
                        <svg class="w-6 h-6 fill-stone-500 group-hover:fill-stone-950 transition-colors duration-500" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z""")/>></svg>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">Facebook</span>
                </a>

                <!-- WhatsApp
                <a href="https://wa.me" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-[#25D366] transition-all duration-500 shadow-xl">
                        <svg class="w-6 h-6 fill-stone-500 group-hover:fill-white transition-colors duration-500" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412 0 6.556-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.223-3.673l.339.202c1.457.867 3.132 1.324 4.842 1.325h.005c5.648 0 10.243-4.595 10.243-10.242 0-2.737-1.066-5.31-3.003-7.248-1.937-1.938-4.51-3.002-7.246-3.002-5.648 0-10.243 4.596-10.243 10.243 0 2.042.607 4.02 1.754 5.697l.222.327-.999 3.647 3.733-.979z""")/>></svg>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">WhatsApp</span>
                </a> -->

                <!-- Instagram -->
                <a href="https://www.instagram.com/ristorantealloggiocascirocco/" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-white transition-all duration-500 shadow-xl">
                        <svg class="w-6 h-6 fill-stone-500 group-hover:fill-stone-950 transition-colors duration-500" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z""")/>></svg>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">Instagram</span>
                </a>

                <!-- TripAdvisor -->
                <a href="https://www.tripadvisor.it/Restaurant_Review-g230072-d3642589-Reviews-Ristorante_Alloggio_Ca_Scirocco-Rovigo_Province_of_Rovigo_Veneto.html?m=69573" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-[#00af87] transition-all duration-500 shadow-xl">
                        <svg class="w-6 h-6 fill-stone-500 group-hover:fill-white transition-colors duration-500" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5.5-9c.83 0 1.5.67 1.5 1.5S7.33 14 6.5 14 5 13.33 5 12.5 5.67 11 6.5 11zm11 0c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z""")/>></svg>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">TripAdvisor</span>
                </a>

        </div>

        <!-- Legal & Credits -->
        <div class="mt-12 pt-8 border-t border-white/5 flex flex-col items-center gap-6">
           <!-- Parte Inferiore: Link Legali Ottimizzati -->
            <div class="flex flex-wrap justify-center gap-8 md:gap-12 mb-8">
                <button @click="legalModal = 'privacy'" class="footer-legal-link">Privacy Policy</button>
                <button @click="legalModal = 'cookies'" class="footer-legal-link">Cookie Policy</button>
                <button @click="legalModal = 'terms'" class="footer-legal-link">Termini & Condizioni</button>
            </div>

            <div class="text-center text-[10px] tracking-[0.2em] text-stone-500">
                <p>© {{ date('Y') }} Cà Scirocco di Zanella Mirko — P.IVA 01492160294 — Via Volta Scirocco 3, 45011 - Adria (RO)</p>
            </div>
        </div>
    </div>

    <!-- BANNER COOKIE -->
    <div x-show="cookieConsent" x-transition:enter="transition duration-500" x-transition:enter-start="translate-y-full"
         class="fixed bottom-0 left-0 w-full z-[150] p-4 md:p-6" x-cloak>
        <div class="max-w-4xl mx-auto bg-white shadow-2xl p-6 border flex flex-col md:flex-row items-center gap-6">
            <div class="flex-1 text-stone-900"><h4 class="font-serif italic text-xl mb-1">Privacy & Cookie</h4>
                <p class="text-stone-500 text-[10px] uppercase tracking-widest">Usiamo i cookie per offrirti il meglio. <button @click="legalModal = 'cookies'" class="underline">Dettagli</button></p>
            </div>
            <button @click="localStorage.setItem('cookie_consent', 'accepted'); cookieConsent = false" class="bg-stone-950 text-white px-8 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-amber-800 transition">Accetta Tutti</button>
        </div>
    </div>

    <!-- OVERLAY MODALE LEGALE -->
    <div x-show="legalModal" class="fixed inset-0 z-[200] flex items-center justify-center p-4" x-cloak>
        <div x-show="legalModal" x-transition.opacity @click="legalModal = null" class="absolute inset-0 bg-stone-950/90 backdrop-blur-md"></div>
        <div x-show="legalModal" x-transition:enter="transition duration-300 scale-95" class="relative bg-white w-full max-w-4xl max-h-[85vh] overflow-y-auto shadow-2xl p-8 md:p-16 rounded-sm text-stone-800">
            <button @click="legalModal = null" class="absolute top-6 right-6 text-stone-400 text-3xl">&times;</button>
            
            <div x-show="legalModal === 'privacy'">
                <h2 class="font-serif italic text-4xl mb-6 text-stone-900">Privacy Policy</h2>
                <p class="text-sm leading-relaxed mb-4"><strong>Titolare:</strong> Cà Scirocco di Zanella Mirko</p>
                <p class="text-sm leading-relaxed">I dati raccolti (Nome, Email) servono solo per gestire le tue prenotazioni. Non cediamo dati a terzi.</p>
            </div>
            <div x-show="legalModal === 'cookies'">
                <h2 class="font-serif italic text-4xl mb-6 text-stone-900">Cookie Policy</h2>
                <p class="text-sm leading-relaxed">Utilizziamo cookie tecnici per il funzionamento e cookie social per le mappe e i link Instagram/Facebook.</p>
            </div>
            <div x-show="legalModal === 'terms'">
                <h2 class="font-serif italic text-4xl mb-6 text-stone-900">Termini & Condizioni</h2>
                <p class="text-sm leading-relaxed">Le prenotazioni sono soggette a disponibilità. In caso di ritardo, il tavolo è garantito per 20 minuti.</p>
            </div>
        </div>
    </div>
</footer>




<!-- 1. OVERLAY LEGALE (MODAL UNICO) -->
<div x-show="legalModal" 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-10"
     x-cloak
     @keydown.escape.window="legalModal = null">
    
    <!-- Sfondo scuro sfocato -->
    <div x-show="legalModal" 
         x-transition.opacity
         @click="legalModal = null" 
         class="absolute inset-0 bg-stone-950/90 backdrop-blur-md"></div>

    <!-- Contenitore Bianco -->
    <div x-show="legalModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative bg-white w-full max-w-4xl max-h-[85vh] overflow-y-auto shadow-2xl p-8 md:p-16 rounded-sm text-stone-800">
        
        <!-- Tasto Chiusura -->
        <button @click="legalModal = null" class="absolute top-6 right-6 text-stone-400 hover:text-stone-900 transition text-3xl font-light">&times;</button>

        <div class="relative bg-white w-full max-w-3xl max-h-[85vh] overflow-y-auto shadow-2xl p-8 md:p-16 rounded-sm border-t-4 border-amber-700 custom-scrollbar">
            <!-- PRIVACY POLICY -->
            <template x-if="legalModal === 'privacy'">
                <div data-aos="fade-in">
                    <h2>Privacy Policy</h2>
                    <h4>Titolare del Trattamento</h4>
                    <p>Cà Scirocco di Zanella Mirko — Via Volta Scirocco 3, 45011 - Adria (RO). Email: info@cascirocco.it</p>
                    
                    <h4>Finalità dei Dati</h4>
                    <p>I dati personali raccolti tramite i nostri moduli di contatto e prenotazione vengono utilizzati esclusivamente per la gestione delle richieste degli ospiti e per l'erogazione dei servizi di ristorazione e alloggio.</p>
                    
                    <h4>Sicurezza & Diritti</h4>
                    <p>Adottiamo misure di sicurezza rigorose per prevenire la perdita o l'uso illecito dei dati. In conformità al GDPR, l'utente può richiedere in ogni momento l'accesso, la rettifica o la cancellazione dei propri dati personali.</p>
                </div>
            </template>

            <!-- COOKIE POLICY -->
            <template x-if="legalModal === 'cookies'">
                <div data-aos="fade-in">
                    <h2>Cookie Policy</h2>
                    <p>Utilizziamo strumenti digitali minimi per garantirti un'esperienza fluida e sicura sul nostro portale.</p>
                    
                    <h4>Cookie Tecnici</h4>
                    <p>Essenziali per la navigazione, il salvataggio delle preferenze di lingua e il corretto funzionamento del sistema di prenotazione.</p>
                    
                    <h4>Sistemi di Terze Parti</h4>
                    <p>Il sito potrebbe integrare contenuti di piattaforme esterne per arricchire l'esperienza informativa:</p>
                    <ul>
                        <li>Mappe interattive di Google Maps</li>
                        <li>Widget e link di condivisione Instagram e Facebook</li>
                        <li>Certificati di eccellenza TripAdvisor</li>
                    </ul>
                </div>
            </template>

            <!-- TERMINI & CONDIZIONI -->
            <template x-if="legalModal === 'terms'">
                <div data-aos="fade-in">
                    <h2>Termini & Condizioni</h2>
                    <h4>Prenotazioni Ristorante</h4>
                    <p>La prenotazione online è soggetta a conferma automatica o manuale da parte del nostro staff. Si prega di segnalare eventuali ritardi superiori ai 15 minuti.</p>
                    
                    <h4>Soggiorno negli Alloggi</h4>
                    <p>Il check-in e il check-out seguono gli orari indicati nella mail di conferma. Eventuali cancellazioni devono pervenire entro i termini stabiliti per evitare penali.</p>
                    
                    <h4>Controversie</h4>
                    <p>Per ogni controversia relativa all'uso del sito o alle prenotazioni, il foro competente è quello di Rovigo.</p>
                </div>
            </template>
        </div>

    </div>
</div>

<!-- 2. BANNER COOKIE INIZIALE (Quello che appare subito) -->
<div x-data="{ 
        cookieBanner: !localStorage.getItem('cookieAccepted'),
        accept() {
            localStorage.setItem('cookieAccepted', 'true');
            this.cookieBanner = false;
        }
     }" 
     x-show="cookieBanner"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     class="fixed bottom-6 left-6 right-6 md:left-auto md:right-10 md:max-w-sm bg-stone-900 text-white z-[90] p-6 shadow-2xl border border-stone-800 rounded-sm"
     x-cloak>
    
    <div class="flex flex-col gap-4">
        <h3 class="text-[10px] font-bold uppercase tracking-[0.3em] text-amber-600">Informativa Cookie</h3>
        <p class="text-[9px] uppercase tracking-widest leading-relaxed text-stone-400">
            Cà Scirocco utilizza i cookie per migliorare l'esperienza. Proseguendo acconsenti al loro uso.
        </p>
        <div class="flex gap-3">
            <button @click="accept()" class="flex-1 bg-white text-stone-950 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-amber-600 hover:text-white transition-all">Accetto</button>
            <button @click="legalModal = 'cookies'" class="flex-1 border border-stone-700 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-stone-800 transition-all">Dettagli</button>
        </div>
    </div>
</div>


<!-- SCRIPTS AGGIUNTIVI -->
 <script>
    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>

@livewireScripts

</body>