<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cà Scirocco | Menù del Giorno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fcfbf7; color: #1c1917; }
        h1, h2, .font-serif { font-family: 'Playfair Display', serif; }
        .btn-cantina {
            display: inline-block;
            padding: 12px 24px;
            background-color: #7c2d12; /* orange-900 */
            color: white;
            border-radius: 9999px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.75rem;
            transition: all 0.3s ease;
        }
        .btn-cantina:hover { background-color: #441507; transform: translateY(-2px); }
    </style>
</head>
<body class="antialiased">

    <!-- Header -->
    <header class="py-10 px-6 text-center border-b border-stone-200 bg-white shadow-sm">
        <h1 class="text-4xl font-bold text-stone-800 tracking-tight">Cà Scirocco</h1>
        <div class="mt-2 flex justify-center items-center gap-2">
            <span class="h-[1px] w-8 bg-orange-300"></span>
            <p class="text-stone-500 uppercase tracking-[0.2em] text-[10px]">Dalla Terra alla Tavola</p>
            <span class="h-[1px] w-8 bg-orange-300"></span>
        </div>
        <div class="mt-4 inline-block px-4 py-1 border border-orange-100 rounded-full bg-orange-50/30">
            <p class="text-[11px] text-orange-800 uppercase tracking-widest font-semibold">
                Menù del {{ now()->translatedFormat('d F Y') }}
            </p>
        </div>
    </header>
<main class="max-w-3xl mx-auto px-6 py-12">
    <h1 class="text-4xl text-center italic font-serif mb-16 text-stone-800">Menù digitale del giorno</h1>

    @foreach($dishes as $categoria => $items)
        <section class="mb-20">
            <!-- Titolo Sezione con Linea decorativa -->
            <div class="flex items-center gap-6 mb-10">
                <span class="flex-grow h-px bg-stone-200"></span>
                <h2 class="text-xs uppercase tracking-[0.4em] font-bold text-orange-800 bg-orange-50 px-4 py-1 rounded-full">
                    {{ $categoria }}
                </h2>
                <span class="flex-grow h-px bg-stone-200"></span>
            </div>

            <div class="space-y-10">
                @foreach($items as $piatto)
                    <div class="flex justify-between items-start group">
                        <div class="max-w-[75%]">
                            <h3 class="text-lg font-bold text-stone-900 uppercase tracking-tight group-hover:text-orange-900 transition">
                                {{ $piatto->name }}
                            </h3>
                            @if($piatto->description)
                                <p class="text-sm text-stone-500 italic leading-relaxed mt-1">
                                    {{ $piatto->description }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-stone-900">
                                {{ number_format($piatto->price, 2, ',', '.') }}€
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

    <!-- Footer Bottone Cantina -->
    <div class="mt-20 text-center border-t border-stone-100 pt-10">
        <p class="text-stone-400 text-sm mb-4">Vuoi abbinare un vino o vedere il menu completo?</p>
        
        <a href="{{ url('cantina') }}" 
           class="inline-block px-8 py-3 bg-stone-900 text-white text-xs uppercase tracking-widest font-bold rounded-full hover:bg-orange-900 transition shadow-xl">
            Consulta la Carta dei Vini
        </a>
        <a href="{{ url('il-menu') }}" 
           class="inline-block px-8 py-3 bg-stone-900 text-white text-xs uppercase tracking-widest font-bold rounded-full hover:bg-orange-900 transition shadow-xl">
            Consulta il menu stagionale
        </a>

    </div>
     <div class="mt-24 text-center border-t border-stone-100 pt-10 pb-20">
            <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-stone-900 text-white text-[10px] uppercase tracking-[0.2em] font-bold rounded-full hover:bg-orange-900 transition shadow-lg">
                ← Torna alla Home
            </a>
        </div>
</main>



</body>
</html>
