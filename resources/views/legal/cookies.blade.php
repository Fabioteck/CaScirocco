<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Policy - Cà Scirocco</title>
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}?v={{ time() }}">
</head>
<body class="bg-stone-50 text-stone-900 antialiased">
    <nav class="sticky top-0 left-0 w-full z-40 bg-white border-b border-stone-100 px-6 py-3">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo_nero.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="text-lg font-serif font-bold text-stone-900 uppercase tracking-tighter">Cà Scirocco</span>
            </a>
        </div>
    </nav>

    <main class="min-h-screen py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-6 bg-white p-8 md:p-12 shadow-sm border border-stone-100">
            <span class="text-amber-700 uppercase tracking-[0.4em] text-[10px] font-bold block mb-4">Documentazione Legale</span>
            <h1 class="font-serif text-4xl md:text-5xl italic text-stone-900 mb-8">Cookie Policy</h1>
            
            <div class="prose prose-stone max-w-none text-stone-600 leading-relaxed text-sm">
                <p class="mb-6">Questa pagina descrive l'utilizzo dei cookie tecnici e funzionali nel sito Cà Scirocco.</p>
            </div>

            <div class="mt-10 pt-6 border-t border-stone-100">
                <a href="{{ url('/') }}" class="text-[10px] font-bold uppercase tracking-widest text-stone-900 hover:text-amber-700 transition">
                    ← Torna alla Home Page
                </a>
            </div>
        </div>
    </main>
</body>
</html>
