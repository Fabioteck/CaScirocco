<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Page Title' }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo_nero.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>

   <body class="bg-stone-50"> 
   <!-- Navigazione -->
    <nav class="fixed w-full z-50 transition-all duration-500 bg-white/95 backdrop-blur-md border-b border-stone-200/50 py-4 px-6 lg:px-12 flex justify-between items-center">

        <!-- Logo -->
        <div class="text-2xl md:text-3xl font-serif font-bold text-stone-800 tracking-tighter italic hover:text-amber-800 transition-colors cursor-pointer">
            <a href="{{ url('/') }}">Cà Scirocco</a>
        </div>
        
        <!-- Menu Desktop (Visibile solo su LG) -->
        <div class="hidden lg:flex items-center space-x-8 text-[11px] uppercase tracking-[0.2em] font-bold text-stone-500">
            <a href="#ristorante" class="hover:text-amber-700 transition-colors">Ristorante</a>
            <a href="#alloggi" class="hover:text-amber-700 transition-colors">Alloggi</a>
            <a href="#eventi" class="hover:text-amber-700 transition-colors">Eventi</a>
            <a href="#staff" class="hover:text-amber-700 transition-colors">Staff</a>
            <a href="#contatti" class="hover:text-amber-700 transition-colors">Contatti</a>
        </div>

        <!-- Azioni e Hamburger -->
        <div class="flex items-center gap-4">
            <!-- Bottone Prenota (Nascosto su mobile molto piccolo) -->
            <a href="#prenota-tavolo" class="hidden sm:block bg-stone-950 text-white px-6 py-2.5 text-[10px] uppercase tracking-widest font-bold hover:bg-amber-800 transition-all duration-300 shadow-md">
                Prenota Tavolo
            </a>

            <!-- Hamburger Button (Vanilla JS - Zero conflitti) -->
            <button onclick="toggleMenu()" class="lg:hidden text-stone-900 p-2 focus:outline-none hover:bg-stone-100 rounded-lg transition-colors">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Overlay (Inizia con 'hidden') -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 w-full bg-white shadow-2xl border-t border-stone-100 lg:hidden flex flex-col p-8 space-y-6 text-stone-600 font-bold uppercase tracking-widest text-[12px] z-50">
            <a href="#ristorante" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="hover:text-amber-800 border-b border-stone-50 pb-2">Ristorante</a>
            <a href="#alloggi" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="hover:text-amber-800 border-b border-stone-50 pb-2">Alloggi</a>
            <a href="#eventi" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="hover:text-amber-800 border-b border-stone-50 pb-2">Eventi</a>
            <a href="#staff" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="hover:text-amber-800 border-b border-stone-50 pb-2">Staff</a>
            <a href="#contatti" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="hover:text-amber-800 pb-2">Contatti</a>
            
            <!-- Bottone Prenota dentro il menu mobile -->
            <a href="#prenota-tavolo" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="bg-stone-950 text-white py-4 text-center text-[10px] tracking-[0.3em]">
                PRENOTA ORA
            </a>
        </div>
    </nav>

   <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{ $slot }} <!-- Qui Livewire inietterà il contenuto della cantina -->
    </main>

    <!-- SEZIONE SOCIAL & FOOTER INTEGRATA -->
    <footer class="bg-stone-950 text-white pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4">
            
            <!-- Parte Superiore: Social Network -->
            <div class="flex flex-col items-center mb-24">
                <span class="text-amber-700 uppercase tracking-[0.5em] text-[10px] font-bold block mb-4">Rimani Connesso</span>
                <h2 class="text-5xl font-serif italic text-white mb-16 text-center">Social Network</h2>

                <div class="flex flex-wrap justify-center gap-8 md:gap-12">
                    <!-- Facebook -->
                    <a href="#" target="_blank" class="group flex flex-col items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-white group-hover:border-white transition-all duration-500 shadow-xl">
                            <svg class="w-6 h-6 fill-stone-500 group-hover:fill-stone-950 transition-colors duration-500" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/></svg>
                        </div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">Facebook</span>
                    </a>

                    <!-- Instagram -->
                    <a href="#" target="_blank" class="group flex flex-col items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-white group-hover:border-white transition-all duration-500 shadow-xl">
                            <svg class="w-6 h-6 fill-stone-500 group-hover:fill-stone-950 transition-colors duration-500" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">Instagram</span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="#" target="_blank" class="group flex flex-col items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-[#25D366] group-hover:border-[#25D366] transition-all duration-500 shadow-xl">
                            <svg class="w-6 h-6 fill-stone-500 group-hover:fill-white transition-colors duration-500" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412 0 6.556-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.223-3.673l.339.202c1.457.867 3.132 1.324 4.842 1.325h.005c5.648 0 10.243-4.595 10.243-10.242 0-2.737-1.066-5.31-3.003-7.248-1.937-1.938-4.51-3.002-7.246-3.002-5.648 0-10.243 4.596-10.243 10.243 0 2.042.607 4.02 1.754 5.697l.222.327-.999 3.647 3.733-.979z"/></svg>
                        </div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">WhatsApp</span>
                    </a>

                    <!-- TripAdvisor -->
                    <a href="#" target="_blank" class="group flex flex-col items-center gap-4">
                        <div class="w-14 h-14 flex items-center justify-center bg-stone-900 border border-stone-800 rounded-full group-hover:bg-[#00af87] group-hover:border-[#00af87] transition-all duration-500 shadow-xl">
                            <svg class="w-6 h-6 fill-stone-500 group-hover:fill-white transition-colors duration-500" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 10 10 10-4.48 10-10S17.51 2 11.99 2zM5.5 16c-1.38 0-2.5-1.12-2.5-2.5S4.12 11 5.5 11s2.5 1.12 2.5 2.5S6.88 16 5.5 16zm13 0c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </div>
                        <span class="text-[9px] uppercase tracking-[0.3em] text-stone-500 group-hover:text-white transition-all duration-500">TripAdvisor</span>
                    </a>
                </div>
            </div>

            <!-- Parte Inferiore: Legal & Credits -->
            <div class="mt-20 pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 text-[10px] uppercase tracking-[0.3em] text-stone-600">
                <div class="flex gap-10">
                    <a href="#" class="hover:text-amber-700 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-amber-700 transition">Cookie Policy</a>
                    <a href="#" class="hover:text-amber-700 transition">Termini & Condizioni</a>
                </div>
                <p class="text-center md:text-right">
                    &copy; {{ date('Y') }} Cà Scirocco — 
                    <a href="https://digitalone.it" class="text-stone-400 hover:text-amber-800 transition">Made with Passion</a>
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>